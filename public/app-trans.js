salla.onReady().then(function(){
    let page = salla.config.get("page")
        let pageUrl = page.slug;
        if (pageUrl === "product.single") {
            salla.lang.add('pages.product.mega_inq_btn', {'ar': "إرسال", 'en': "Send"});
            salla.lang.add('pages.product.mega_inq_title', {'ar': "استعلام عن المنتج", 'en': "Inquiry For Product"});
            salla.lang.add('pages.product.mega_inq_name', {'ar': "اسمك", 'en': "Your Name"});
            salla.lang.add('pages.product.mega_inq_email', {'ar': "بريدك الإلكتروني", 'en': "Your Email"});
            salla.lang.add('pages.product.mega_inq_phone', {'ar': "رقم واتساب الخاص بك", 'en': "Your Whatsapp Number"});
            salla.lang.add('pages.product.mega_inq_query', {'ar': "رسالة الاستفسار", 'en': "Your inquiry message"});
            salla.lang.add('pages.product.mega_inq_main_btn_title', {'ar': "استعلام", 'en': "Inquiry"});
            salla.lang.add('pages.product.mega_inq_success_msg', {'ar': "شكرا لاستفسارك", 'en': "Thank you for your inquiry!"});
            salla.lang.add('pages.product.mega_inq_whats_open', {'ar': "فتح واتساب في", 'en': "Opening WhatsApp in"});
            salla.lang.add('pages.product.mega_inq_whats_open_second', {'ar': "ثوان..", 'en': "seconds..."});
            salla.lang.add('pages.product.mega_inq_error_msg', {'ar': "كل الحقول مطلوبة", 'en': "All fields are required"});
        }
});