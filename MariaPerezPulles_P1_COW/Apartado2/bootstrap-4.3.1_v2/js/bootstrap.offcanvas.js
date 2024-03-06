jQuery(document).ready(function($) {
   var bsDefaults = {
       offset: true,
       overlay: false,
       width: '330px'
   },
   bsMain = $('.bs-offset-main'),
   bsOverlay = $('.bs-canvas-overlay');

   $('[data-toggle="canvas"]').on('click', function() {
       var canvas = $(this).data('target'),
           opts = $.extend({}, bsDefaults, $(canvas).data()),
           prop = $(canvas).hasClass('bs-canvas-right') ? 'margin-right' : 'margin-left';

       // Verificar si el canvas está abierto o cerrado
       var isOpen = $(this).attr('aria-expanded') == 'true';

       if (!isOpen) { // Si está cerrado, abrirlo
           if (opts.width === '100%')
               opts.offset = false;
           
           $(canvas).css('width', opts.width);
           if (opts.offset && bsMain.length)
               bsMain.css(prop, opts.width);
   
           $(canvas + ' .bs-canvas-close').attr('aria-expanded', "true");
           $('[data-toggle="canvas"][data-target="' + canvas + '"]').attr('aria-expanded', "true");
           if (opts.overlay && bsOverlay.length)
               bsOverlay.addClass('show');
       } else { // Si está abierto, cerrarlo
           $(canvas).css('width', '');
           $(canvas + ' .bs-canvas-close, [data-toggle="canvas"][data-target="' + canvas + '"]').attr('aria-expanded', "false");
           if (bsMain.length)
               bsMain.css({
                   'margin-left': '',
                   'margin-right': ''
               });
           if (bsOverlay.length)
               bsOverlay.removeClass('show');
       }

       return false;
   });

   // Cerrar el canvas con el botón de cerrar o haciendo clic en el overlay
   $('.bs-canvas-close, .bs-canvas-overlay').on('click', function() {
       var canvas, aria;
       if ($(this).hasClass('bs-canvas-close')) {
           canvas = $(this).closest('.bs-canvas');
           aria = $(this).add($('[data-toggle="canvas"][data-target="#' + canvas.attr('id') + '"]'));
       } else {
           canvas = $('.bs-canvas');
           aria = $('.bs-canvas-close, [data-toggle="canvas"]');
       }
       canvas.css('width', '');
       aria.attr('aria-expanded', "false");
       if (bsMain.length)
           bsMain.css({
               'margin-left': '',
               'margin-right': ''
           });
       if (bsOverlay.length)
           bsOverlay.removeClass('show');
       return false;
   });
});
