//######
//## This work is licensed under the Creative Commons Attribution-Share Alike 3.0
//## United States License. To view a copy of this license,
//## visit http://creativecommons.org/licenses/by-sa/3.0/us/ or send a letter
//## to Creative Commons, 171 Second Street, Suite 300, San Francisco, California, 94105, USA.
//######

(function($){
    $.fn.idleTimeout = function(options) {
        var defaults = {
            inactivity: 100,//1200000, //20 Minutes
            noconfirm: 10000, //10 Seconds
            sessionAlive: 20,//30000, //10 Minutes
            redirect_url: '/auth/acceder/',
            click_reset: true,
            alive_url: '/js_sandbox/',
            logout_url: '/auth/acceder/',
            showDialog: true,
            dialogTitle: 'TU SESION ESTA A PUNTO DE CADUCAR',
            dialogText: 'Por Seguridad el sistema esta a punto de Cerrar tu Sesión ¿Deseas seguir Conectado?.',
            dialogButton: 'Seguir Conectado'
        }

        //##############################
        //## Private Variables
        //##############################
        var opts = $.extend(defaults, options);
        var liveTimeout, confTimeout, sessionTimeout;
        var modal = "<div id='modal_pop'><p>"+opts.dialogText+"</p></div>";

        //##############################
        //## Private Functions
        //##############################
        var start_liveTimeout = function()
        {
            clearTimeout(liveTimeout);
            clearTimeout(confTimeout);
            liveTimeout = setTimeout(logout, opts.inactivity);

            if(opts.sessionAlive)
            {
                clearTimeout(sessionTimeout);
                sessionTimeout = setTimeout(keep_session, opts.sessionAlive);
            }
        }

        var logout = function()
        {
            var my_dialog;
            var buttonsOpts = {};

            confTimeout = setTimeout(redirect, opts.noconfirm);

            buttonsOpts[opts.dialogButton] = function(){
                my_dialog.dialog('close');
                stay_logged_in();
            }

            if(opts.showDialog)
            {
                my_dialog = $(modal).dialog({
                    buttons: buttonsOpts,
                    modal: true,
                    title: opts.dialogTitle
                });
            }
        }

        var redirect = function()
        {
            if(opts.logout_url)
            {
                $.get(opts.logout_url);
            }
            window.location.href = opts.redirect_url;
        }

        var stay_logged_in = function(el)
        {
            start_liveTimeout();
            if(opts.alive_url)
            {
                $.get(opts.alive_url);
            }
        }

        var keep_session = function()
        {
            $.get(opts.alive_url);
            clearTimeout(sessionTimeout);
            sessionTimeout = setTimeout(keep_session, opts.sessionAlive);
        }

        //###############################
        //Build & Return the instance of the item as a plugin
        // This is basically your construct.
        //###############################
        return this.each(function() {
            obj = $(this);
            start_liveTimeout();
            if(opts.click_reset)
            {
                $(document).bind('click', start_liveTimeout);
            }
            if(opts.sessionAlive)
            {
                keep_session();
            }
        });

    };
})(jQuery);