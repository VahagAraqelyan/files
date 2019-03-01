/*
 * jQuery Bootstrap Responsive Tabs v2.0.1 | Valeriu Timbuc - vtimbuc.com
 * github.com/vtimbuc/bootstrap-responsive-tabs
 * @license WTFPL http://www.wtfpl.net/about/
 */


;(function($) {

    "use strict";

    var defaults = {
        accordionOn: ['xs'] // xs, sm, md, lg
    };

    $.fn.responsiveTabs = function (options) {

        var config = $.extend({}, defaults, options),
            accordion = '';

        $.each(config.accordionOn, function (index, value) {

            accordion += ' accordion-' + value;
        });

        return this.each(function () {

            var $self = $(this),
                $navTabs = $self.find('> li > a'),
                $tabContent = $($navTabs.first().attr('href')).parent('.tab-content'),
                $tabs = $tabContent.children('.tab-pane');

            // Wrap the tabs
            $self.add($tabContent).wrapAll('<div class="responsive-tabs-container" />');

            var $container = $self.parent('.responsive-tabs-container');

            $container.addClass(accordion);

            //  MY code from  mobile
            if($(window).width()< 767) {

                if($tabs.hasClass('active')){
                    $tabs.removeClass('active');

                }

                $tabs.each(function(index) {

                    var id = $(this).attr('id');

                    if(!$(this).hasClass('active')){


                        $(this).addClass('close_tab');


                    }

                    if($(this).hasClass('close_tab')){

                        $(this).addClass('close_tab_panel');
                        $(this).removeClass('my_active_class');
                        $("a[href = '"+id+"']").find('i').first().addClass('fa-angle-down');
                        $("a[href = '"+id+"']").find('i').first().removeClass('fa-angle-up');

                    }else{
                        $(this).removeClass('close_tab_panel');
                        $(this).addClass('my_active_class');
                        $("a[href = '"+id+"']").find('i').first().addClass('fa-angle-up');
                        $("a[href = '"+id+"']").find('i').first().removeClass('fa-angle-down');
                    }

                });

            }

            // Duplicate links for accordion
            $navTabs.each(function (i) {
                var $this = $(this),
                    id = $this.attr('href'),
                    active = '',
                    first = '',
                    last = '';

                // Add active class
                if ($this.parent('li').hasClass('active')) {

                    active = ' active';

                }

                // Add first class
                if (i === 0) {
                    first = ' first';
                }

                // Add last class
                if (i === $navTabs.length - 1) {
                    last = ' last';
                }

                $this.clone(false).addClass('accordion-link' + active + first + last).insertBefore(id);

            });

            var $accordionLinks = $tabContent.children('.accordion-link');



            //  MY code from  mobile
            if($(window).width()< 767) {

            /*    $accordionLinks.on('click', function () {


                });*/

                $(document).on('click','.accordion-link',function () {
                    $tabs.each(function(index) {
                        var id = $(this).attr('id');
                        $("a[href = '"+'#' + id+"']").children('i:eq(1)').addClass('fa-angle-down');
                        $("a[href = '"+'#' + id+"']").children('i:eq(1)').removeClass('fa-angle-up');

                    });

                    var attr_href = $(this).attr('href').replace('#','');

                    if($('#'+attr_href).hasClass('close_tab')){

                        $(this).children('i').first().addClass('fa-angle-up');
                        $(this).children('i').first().removeClass('fa-angle-down');

                        $('.tab-pane').addClass('close_tab');
                        $('#'+ attr_href).removeClass('close_tab');
                        $('#'+ attr_href).removeClass('close_tab_panel');
                        $('#'+attr_href).addClass('my_active_class');
                        console.log('baca');
                    }else{
                        $(this).children('i').first().addClass('fa-angle-down');
                        $(this).children('i').first().removeClass('fa-angle-up');

                        $('#'+attr_href).removeClass('my_active_class');
                        $('#'+attr_href).addClass('close_tab_panel');
                        $('#'+attr_href).addClass('close_tab');
                    }
                });
            }


            // Tabs Click Event
          $navTabs.on('click', function (event) {

                event.preventDefault();

                var $this = $(this),
                    $li = $this.parent('li'),
                    $siblings = $li.siblings('li'),
                    id = $this.attr('href'),
                    $accordionLink = $tabContent.children('a[href="' + id + '"]');

                if (!$li.hasClass('active')) {
                    $li.addClass('active');
                    $siblings.removeClass('active');

                    $tabs.removeClass('active');
                    $(id).addClass('active');

                    $accordionLinks.removeClass('active');
                    $accordionLink.addClass('active');
                }
            });

            // Accordion Click Event
           $accordionLinks.on('click', function (event) {

                if($(window).width() > 767) {

                    event.preventDefault();

                    var $this = $(this),
                        id = $this.attr('href'),
                        $tabLink = $self.find('li > a[href="' + id + '"]').parent('li');

                    if (!$this.hasClass('active')) {
                        $accordionLinks.removeClass('active');
                        $this.addClass('active');

                        $tabs.removeClass('active');
                        $(id).addClass('active');

                        $navTabs.parent('li').removeClass('active');
                        $tabLink.addClass('active');
                    }
                }
                //$('.order-details-content').find('a').click(function () {

                   $tabs.each(function(index) {

                        if($(this).hasClass('active')){

                            $(this).removeClass('active');
                        }

                       if ( $(this).css('display') == 'block' ){

                         $(this).css('display','none')
                         }
                    });



                //});



            });

        });

    };

}(jQuery));