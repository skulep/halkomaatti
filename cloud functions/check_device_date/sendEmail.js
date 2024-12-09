const nodemailer = require('nodemailer')

const sendEmail = async (subject, body) => {
    
    const transporter = nodemailer.createTransport({
        service:'gmail',
        auth: {
            user: 'firewoodemail001@gmail.com',
            pass:'HOX!', //App password found in 'error system documentation' word document
        },
        debug: true, // Enable debug logs
        logger: true, // Log to console
    });

    const mailOptions = {
        from: 'firewoodemail001@gmail.com',
        to: 'HOX!', //For testing use own or throwaway. For deployment use kristian's(found in word document).
        subject: subject,
        text: body,
    };

    try
    {
        const data = await transporter.sendMail(mailOptions);
        console.log('mail sent ' + data.response);
        return {success: true, message: 'Email sent'};
    } catch (err) {
        console.error('Error: ' + err);
        throw new Error('Email send failed');
    }
}
module.exports = sendEmail

