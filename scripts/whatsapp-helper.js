/**
 * SIPAKTA - Self-Hosted Open Source WhatsApp Gateway Helper
 * 
 * Script ini menggunakan library open-source 'whatsapp-web.js' untuk membuat API Gateway WhatsApp
 * sendiri secara gratis tanpa biaya bulanan. Anda dapat menjalankan script ini di server lokal
 * atau VPS murah, lalu memindai kode QR untuk menghubungkan nomor HP admin.
 * 
 * Prasyarat:
 * 1. Instal NodeJS & NPM di mesin Anda
 * 2. Instal library: npm install whatsapp-web.js qrcode-terminal express body-parser
 * 
 * Jalankan dengan: node whatsapp-helper.js
 */

const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');
const express = require('express');
const bodyParser = require('body-parser');

const app = express();
const port = 3000; // Port gateway

app.use(bodyParser.json());

// Inisialisasi Klien WhatsApp dengan LocalAuth agar sesi tersimpan otomatis
const client = new Client({
    authStrategy: new LocalAuth(),
    puppeteer: {
        headless: true,
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-dev-shm-usage',
            '--disable-accelerated-2d-canvas',
            '--no-first-run',
            '--no-zygote',
            '--disable-gpu'
        ]
    }
});

// Menampilkan QR Code di terminal untuk dipindai oleh HP WhatsApp Admin
client.on('qr', (qr) => {
    console.log('=== KODE QR SIAP DIPINDAI ===');
    qrcode.generate(qr, { small: true });
    console.log('Pindai kode QR di atas dengan aplikasi WhatsApp Anda (Perangkat Tertaut).');
});

client.on('ready', () => {
    console.log('=== GATEWAY WHATSAPP SIAP & AKTIF ===');
    console.log('Nomor WhatsApp Anda telah sukses tersambung!');
});

client.on('auth_failure', (msg) => {
    console.error('Sesi autentikasi gagal:', msg);
});

// Endpoint untuk mengirim pesan OTP dari Laravel
app.post('/send-message', async (req, res) => {
    const { phone, message } = req.body;

    if (!phone || !message) {
        return res.status(400).json({ success: false, error: 'Nomor telepon dan pesan wajib diisi.' });
    }

    try {
        // Format nomor telepon ke standar internasional (contoh: 628123456789@c.us)
        let formattedPhone = phone.replace(/[^0-9]/g, '');
        if (formattedPhone.startsWith('0')) {
            formattedPhone = '62' + formattedPhone.substring(1);
        }
        if (!formattedPhone.endsWith('@c.us')) {
            formattedPhone = formattedPhone + '@c.us';
        }

        // Kirim pesan
        const chat = await client.sendMessage(formattedPhone, message);
        console.log(`Pesan terkirim ke ${phone}: ${message}`);
        
        return res.json({ success: true, messageId: chat.id._serialized });
    } catch (error) {
        console.error('Gagal mengirim WhatsApp:', error);
        return res.status(500).json({ success: false, error: error.message });
    }
});

// Start API Server
app.listen(port, () => {
    console.log(`Express Gateway Server berjalan di http://localhost:${port}`);
    console.log('Menghubungkan ke WhatsApp Web...');
    client.initialize();
});

/*
 * CARA MENGHUBUNGKAN DENGAN LARAVEL (SIPAKTA):
 * 
 * Edit file .env di Laravel Anda dan pasangkan konfigurasi berikut:
 * 
 * WA_GATEWAY_URL=http://localhost:3000/send-message
 * WA_GATEWAY_TOKEN=optional_secret_token
 */
