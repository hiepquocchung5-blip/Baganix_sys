/**
 * 🌟 Baganix E2EE Client Engine
 * Uses pure WebCrypto API. Private keys NEVER leave the browser.
 */

const BaganixCrypto = {
    // Generate a new RSA Key Pair for a new user
    async generateKeyPair() {
        const keyPair = await window.crypto.subtle.generateKey(
            {
                name: "RSA-OAEP",
                modulusLength: 2048,
                publicExponent: new Uint8Array([1, 0, 1]),
                hash: "SHA-256",
            },
            true, // Extractable so we can save it locally
            ["encrypt", "decrypt"]
        );

        // Export Public Key to send to api.Baganix.online
        const exportedPublicKey = await window.crypto.subtle.exportKey("spki", keyPair.publicKey);
        const publicKeyBase64 = btoa(String.fromCharCode(...new Uint8Array(exportedPublicKey)));

        // Export Private Key to save locally in localStorage/IndexedDB
        const exportedPrivateKey = await window.crypto.subtle.exportKey("pkcs8", keyPair.privateKey);
        const privateKeyBase64 = btoa(String.fromCharCode(...new Uint8Array(exportedPrivateKey)));

        // Store private key securely in local browser (Never sent to API)
        localStorage.setItem('bgnx_private_key', privateKeyBase64);

        return publicKeyBase64;
    },

    // Import a base64 key back into a WebCrypto Key Object
    async importKey(base64Key, isPrivate) {
        const binaryDerString = atob(base64Key);
        const binaryDer = new Uint8Array([...binaryDerString].map(char => char.charCodeAt(0)));

        return await window.crypto.subtle.importKey(
            isPrivate ? "pkcs8" : "spki",
            binaryDer,
            { name: "RSA-OAEP", hash: "SHA-256" },
            true,
            isPrivate ? ["decrypt"] : ["encrypt"]
        );
    },

    // Encrypt message using receiver's Public Key (Before sending to PHP API)
    async encryptMessage(text, receiverPublicKeyBase64) {
        const publicKey = await this.importKey(receiverPublicKeyBase64, false);
        const encodedText = new TextEncoder().encode(text);
        
        const encryptedBuffer = await window.crypto.subtle.encrypt(
            { name: "RSA-OAEP" },
            publicKey,
            encodedText
        );
        
        return btoa(String.fromCharCode(...new Uint8Array(encryptedBuffer)));
    },

    // Decrypt message using your own Private Key (After fetching from PHP API)
    async decryptMessage(encryptedBase64) {
        const privateKeyBase64 = localStorage.getItem('bgnx_private_key');
        if (!privateKeyBase64) throw new Error("No private key found in vault.");

        const privateKey = await this.importKey(privateKeyBase64, true);
        const encryptedBytes = Uint8Array.from(atob(encryptedBase64), c => c.charCodeAt(0));

        const decryptedBuffer = await window.crypto.subtle.decrypt(
            { name: "RSA-OAEP" },
            privateKey,
            encryptedBytes
        );

        return new TextDecoder().decode(decryptedBuffer);
    }
};