/* global cookie_pop_text */
jQuery(document).ready(function($) {
    'use strict';

    if (Cookies.get('inv-cookie-pop') != 1) {
        console.log(invcookienoticeoptions.alignment);
        var layerradius = 'border-radius: '+invcookienoticeoptions.layerradius+'; web-kit-border-radius: '+invcookienoticeoptions.layerradius+'; -moz-border-radius: '+invcookienoticeoptions.layerradius+'; ';
        $('body').prepend(
            '<div class="inv-cookie-pop" style="'+layerradius+' color: '+invcookienoticeoptions.cookietextcolor+'; background: linear-gradient(292deg,'+invcookienoticeoptions.backgroundcolor+' 0%,'+invcookienoticeoptions.backgroundcolor2+' 35%,'+invcookienoticeoptions.backgroundcolor3+' 100%);"><p class="firstcol">'+invcookienoticeoptions.domain+ ' '+invcookienoticeoptions.cookietext+' <a href="'+invcookienoticeoptions.privacylink+'" target="_blank" class="privacy-link">'+invcookienoticeoptions.privacylinktext+'</a></p><p class="secondcol"><span class="button" id="accept-cookie" style="border-radius: '+invcookienoticeoptions.buttonradius+'; -moz-border-radius: '+invcookienoticeoptions.buttonradius+'; -webkit-border-radius: '+invcookienoticeoptions.buttonradius+'; background-color: '+invcookienoticeoptions.buttoncolor+'; color: '+invcookienoticeoptions.buttontextcolor+'">'+invcookienoticeoptions.buttontext+'</span></p></div>'
        );
        $('#accept-cookie').click(function () {
            Cookies.set('inv-cookie-pop', '1', { expires: parseInt(invcookienoticeoptions.cookieduration) });
            $('.inv-cookie-pop').remove();
        });
        //Cookies.set('cookie-pop', '1', { expires: 365 });
    }
});