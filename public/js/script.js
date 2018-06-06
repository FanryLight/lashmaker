jQuery(function ($) {
    $("#phone").mask("(999) 999-9999", {placeholder: "(___) ___-____"});

    $('#sendButton').on('click', function (event) {
        event.preventDefault();
        const name = $('#name').val();
        const phone = $('#phone').val();
        let flag = true;
        if (!name) {
            $('#name').parent().addClass('has-error');
            flag = false;
        }
        if (!phone || !(/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/).test(phone)) {
            $('#phone').parent().addClass('has-error');
            flag = false;
        }
        if (flag) {
            $.ajax(
                {
                    url: '/sendContacts',
                    data: {
                        'name': name,
                        'phone': phone
                    },
                    success: function (data) {
                        if (data.resp) {
                            $('#name').val('');
                            $('#phone').val('');
                        }
                    }
                }
            )
        }
    });
});