/**
 * SIPAKTA - Self-Hosted WhatsApp OTP Gateway
 *
 * Menggunakan library open-source 'whatsapp-web.js' (gratis, tanpa biaya bulanan).
 * Script ini berjalan sebagai HTTP server di host Mac Anda (di luar Docker).
 *
 * PRASYARAT:
 *   cd scripts/
 *   npm install
 *   node whatsapp-helper.js
 *
 * Saat pertama kali dijalankan, scan QR code yang muncul di terminal
 * menggunakan WhatsApp Anda > Perangkat Tertaut > Tambah Perangkat.
 */

const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const QRCode = require('qrcode');
const path = require('path');
const fs = require('fs');
const express = require('express');
const bodyParser = require('body-parser');

// ======================================================
// KONFIGURASI — Sesuaikan dengan nilai di .env Laravel
// ======================================================
const PORT = 3000;
const GATEWAY_SECRET_TOKEN = 'sipakta-wa-secret-2024'; // Harus sama dengan WA_GATEWAY_TOKEN di .env
// ======================================================

const app = express();
app.use(bodyParser.json());

// ─── Middleware: Verifikasi Secret Token ─────────────────────────────────────
app.use((req, res, next) => {
    const token = req.body?.token || req.headers['authorization']?.replace('Bearer ', '');
    if (token !== GATEWAY_SECRET_TOKEN) {
        console.warn(`[SECURITY] Akses ditolak - token tidak valid: "${token}"`);
        return res.status(401).json({ success: false, error: 'Unauthorized: Token tidak valid.' });
    }
    next();
});

// ─── Inisialisasi WhatsApp Client ────────────────────────────────────────────
let isClientReady = false;

const client = new Client({
    authStrategy: new LocalAuth({
        dataPath: './.wwebjs_auth', // Sesi tersimpan di folder ini agar tidak perlu scan ulang
    }),
    puppeteer: {
        headless: true,
        executablePath: '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-dev-shm-usage',
            '--disable-accelerated-2d-canvas',
            '--no-first-run',
            '--no-zygote',
            '--single-process',
            '--disable-gpu'
        ]
    }
});

// QR Code muncul di terminal saat belum ada sesi tersimpan
client.on('qr', (qr) => {
    console.log('\n╔══════════════════════════════════════╗');
    console.log('║      SCAN QR CODE INI SEKARANG       ║');
    console.log('╚══════════════════════════════════════╝');
    qrcode.generate(qr, { small: true });
    console.log('\nCara scan: Buka WhatsApp > Perangkat Tertaut > Tambah Perangkat');
    console.log('QR code hanya berlaku ~20 detik. Jika expired, tunggu QR baru muncul.\n');

    // Simpan QR sebagai file gambar PNG di folder public agar bisa dibuka dari browser
    const qrPath = path.join(__dirname, '../public/wa-qr.png');
    QRCode.toFile(qrPath, qr, {
        color: {
            dark: '#000000',
            light: '#FFFFFF'
        },
        width: 300
    }, (err) => {
        if (err) {
            console.error('Gagal membuat file gambar QR Code:', err);
        } else {
            console.log(`📸 File QR Code berhasil diperbarui: ${qrPath}`);
            console.log(`   Silakan buka: http://localhost:8000/wa-qr.png di browser Anda untuk scan.`);
        }
    });
});

client.on('ready', () => {
    isClientReady = true;
    console.log('\n✅ GATEWAY WHATSAPP AKTIF & SIAP MENGIRIM PESAN!');
    console.log(`📡 Server berjalan di http://localhost:${PORT}`);
    console.log('─'.repeat(50));

    // Hapus file QR code demi keamanan setelah sukses tersambung
    const qrPath = path.join(__dirname, '../public/wa-qr.png');
    if (fs.existsSync(qrPath)) {
        try {
            fs.unlinkSync(qrPath);
            console.log('🗑️ File QR Code public dihapus demi keamanan.');
        } catch (err) {
            console.error('Gagal menghapus file QR Code:', err.message);
        }
    }
});

client.on('authenticated', () => {
    console.log('🔑 Autentikasi berhasil. Sesi tersimpan otomatis.');
});

client.on('auth_failure', (msg) => {
    isClientReady = false;
    console.error('❌ Autentikasi GAGAL:', msg);
    console.log('💡 Coba hapus folder .wwebjs_auth dan jalankan ulang.');
});

client.on('disconnected', (reason) => {
    isClientReady = false;
    console.warn('⚠️  WhatsApp terputus:', reason);
    console.log('🔄 Mencoba reconnect dalam 5 detik...');
    setTimeout(() => client.initialize(), 5000);
});

// ─── Endpoint: Health Check ───────────────────────────────────────────────────
app.get('/status', (req, res) => {
    res.json({
        status: isClientReady ? 'ready' : 'initializing',
        message: isClientReady
            ? 'WhatsApp Gateway aktif dan siap digunakan.'
            : 'WhatsApp Gateway sedang menginisialisasi atau belum scan QR.'
    });
});

// ─── Endpoint: Kirim Pesan OTP ────────────────────────────────────────────────
app.post('/send-message', async (req, res) => {
    // Support berbagai key: phone, target (Fonnte-compatible)
    const phone = req.body?.phone || req.body?.target;
    const message = req.body?.message || req.body?.text;

    if (!phone || !message) {
        return res.status(400).json({
            success: false,
            error: 'Parameter "phone" dan "message" wajib diisi.'
        });
    }

    if (!isClientReady) {
        return res.status(503).json({
            success: false,
            error: 'Gateway belum siap. Silakan scan QR code di terminal terlebih dahulu.'
        });
    }

    try {
        // Format nomor ke standar internasional WhatsApp
        let formattedPhone = phone.replace(/[^0-9]/g, '');
        if (formattedPhone.startsWith('0')) {
            formattedPhone = '62' + formattedPhone.substring(1);
        }
        if (!formattedPhone.startsWith('62')) {
            formattedPhone = '62' + formattedPhone;
        }
        const chatId = formattedPhone + '@c.us';

        // Kirim pesan
        const sentMsg = await client.sendMessage(chatId, message);
        
        console.log(`\n📤 OTP terkirim ke ${phone} (${chatId})`);
        console.log(`   Pesan: ${message.split('\n')[0]}...`);

        return res.json({
            success: true,
            messageId: sentMsg.id._serialized,
            to: chatId
        });

    } catch (error) {
        console.error(`\n❌ Gagal mengirim ke ${phone}:`, error.message);
        return res.status(500).json({
            success: false,
            error: error.message
        });
    }
});

// ─── Start Server ─────────────────────────────────────────────────────────────
app.listen(PORT, () => {
    console.log('\n╔══════════════════════════════════════════════╗');
    console.log('║     SIPAKTA - WhatsApp OTP Gateway v2.0      ║');
    console.log('╚══════════════════════════════════════════════╝');
    console.log(`\n🚀 HTTP Server aktif di http://localhost:${PORT}`);
    console.log('⏳ Menginisialisasi koneksi WhatsApp Web...\n');

    // Inisialisasi WhatsApp setelah server siap
    client.initialize();
});
