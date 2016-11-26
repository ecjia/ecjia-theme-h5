'use strict';
/*===========================
ECJIa-H5
===========================*/


window.Framework7 = function (params) {
    // App
    var app = this;

    // Version
    // app.version = '1.2.0';
    app.version = '1.1';

    // Default Parameters
    app.params = {
        cache: true,
        cacheIgnore: [],
        cacheIgnoreGetParameters: false,
        cacheDuration: 1000 * 60 * 10, // Ten minutes
        preloadPreviousPage: true,
        uniqueHistory: false,
        uniqueHistoryIgnoreGetParameters: false,
        dynamicPageUrl: 'content-{{index}}',
        allowDuplicateUrls: false,
        router: true,
        // Push State
        pushState: false,
        pushStateRoot: undefined,
        pushStateNoAnimation: false,
        pushStateSeparator: '#!/',
        pushStatePreventOnLoad: true,
        // Fast clicks
        fastClicks: true,
        fastClicksDistanceThreshold: 10,
        fastClicksDelayBetweenClicks: 50,
        // Tap Hold
        tapHold: false,
        tapHoldDelay: 750,
        tapHoldPreventClicks: true,
        // Active State
        activeState: true,
        activeStateElements: 'a, button, label, span',
        // Animate Nav Back Icon
        animateNavBackIcon: false,
        // Swipe Back
        swipeBackPage: true,
        swipeBackPageThreshold: 0,
        swipeBackPageActiveArea: 30,
        swipeBackPageAnimateShadow: true,
        swipeBackPageAnimateOpacity: true,
        // Ajax
        ajaxLinks: undefined, // or CSS selector
        // External Links
        externalLinks: '.external', // CSS selector
        // Sortable
        sortable: true,
        // Scroll toolbars
        hideNavbarOnPageScroll: false,
        hideToolbarOnPageScroll: false,
        hideTabbarOnPageScroll: false,
        showBarsOnPageScrollEnd: true,
        showBarsOnPageScrollTop: true,
        // Swipeout
        swipeout: true,
        swipeoutActionsNoFold: false,
        swipeoutNoFollow: false,
        // Smart Select Back link template
        smartSelectBackText: 'Back',
        smartSelectInPopup: false,
        smartSelectPopupCloseText: 'Close',
        smartSelectSearchbar: false,
        smartSelectBackOnSelect: false,
        // Tap Navbar or Statusbar to scroll to top
        scrollTopOnNavbarClick: false,
        scrollTopOnStatusbarClick: false,
        // Panels
        swipePanel: false, // or 'left' or 'right'
        swipePanelActiveArea: 0,
        swipePanelCloseOpposite: true,
        swipePanelOnlyClose: false,
        swipePanelNoFollow: false,
        swipePanelThreshold: 0,
        panelsCloseByOutside: true,
        // Modals
        modalButtonOk: 'OK',
        modalButtonCancel: 'Cancel',
        modalUsernamePlaceholder: 'Username',
        modalPasswordPlaceholder: 'Password',
        modalTitle: 'Framework7',
        modalCloseByOutside: false,
        actionsCloseByOutside: true,
        popupCloseByOutside: true,
        modalPreloaderTitle: 'Loading... ',
        modalStack: true,
        // Lazy Load
        imagesLazyLoadThreshold: 0,
        imagesLazyLoadSequential: true,
        // Name space
        viewClass: 'view',
        viewMainClass: 'view-main',
        viewsClass: 'views',
        // Notifications defaults
        notificationCloseOnClick: false,
        notificationCloseIcon: true,
        notificationCloseButtonText: 'Close',
        // Animate Pages
        animatePages: true,
        // Template7
        templates: {},
        template7Data: {},
        template7Pages: false,
        precompileTemplates: false,
        // Material
        material: false,
        materialPageLoadDelay: 0,
        materialPreloaderSvg: '<svg xmlns="http://www.w3.org/2000/svg" height="75" width="75" viewbox="0 0 75 75"><circle cx="37.5" cy="37.5" r="33.5" stroke-width="8"/></svg>',
        materialRipple: true,
        materialRippleElements: '.ripple, a.link, a.item-link, .button, .modal-button, .tab-link, .label-radio, .label-checkbox, .actions-modal-button, a.searchbar-clear, .floating-button',
        // Auto init
        init: true,
    };


    // Extend defaults with parameters
    for (var param in params) {
        app.params[param] = params[param];
    }

    // DOM lib
    // var $ = Dom7;

    // Template7 lib
    // var t7 = Template7;
    // app._compiledTemplates = {};

    // Touch events

    // app.touchEvents = {
    //     start: app.support.touch ? 'touchstart' : 'mousedown',
    //     move: app.support.touch ? 'touchmove' : 'mousemove',
    //     end: app.support.touch ? 'touchend' : 'mouseup'
    // };

    // Link to local storage
    app.ls = window.localStorage;

    // RTL
    app.rtl = $('body').css('direction') === 'rtl';
    if (app.rtl) $('html').attr('dir', 'rtl');

    // Overwrite statusbar overlay
    if (typeof app.params.statusbarOverlay !== 'undefined') {
        if (app.params.statusbarOverlay) $('html').addClass('with-statusbar-overlay');
        else $('html').removeClass('with-statusbar-overlay');
    }

//  APP init

    app.init = function () {
        // Compile Template7 templates on app load
        if (app.initTemplate7Templates) app.initTemplate7Templates();

        // Init Plugins
        if (app.initPlugins) app.initPlugins();

        // Init Device
        if (app.getDeviceInfo) app.getDeviceInfo();

        // Init Click events
        if (app.initFastClicks && app.params.fastClicks) app.initFastClicks();
        if (app.initClickEvents) app.initClickEvents();

        // Init each page callbacks
        $('.page:not(.cached)').each(function () {
            app.initPageWithCallback(this);
        });

        // Init each navbar callbacks
        $('.navbar:not(.cached)').each(function () {
            app.initNavbarWithCallback(this);
        });

        // Init resize events
        if (app.initResize) app.initResize();

        // Init push state
        if (app.initPushState && app.params.pushState) app.initPushState();

        // Init Live Swipeouts events
        if (app.initSwipeout && app.params.swipeout) app.initSwipeout();

        // Init Live Sortable events
        if (app.initSortable && app.params.sortable) app.initSortable();

        // Init Live Swipe Panels
        if (app.initSwipePanels && (app.params.swipePanel || app.params.swipePanelOnlyClose)) app.initSwipePanels();

        // Init Material Inputs
        if (app.params.material && app.initMaterialWatchInputs) app.initMaterialWatchInputs();

        // App Init callback
        if (app.params.onAppInit) app.params.onAppInit();

        // Plugin app init hook
        // app.pluginHook('appInit');
    };
    if (app.params.init) app.init();

// Framework7.prototype.support = (function () {
//     var support = {
//         touch: !!(('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch)
//     };
//
//     // Export object
//     return support;
// })();


    /*======================================================
    ************   Modals   ************
    ======================================================*/
    var _modalTemplateTempDiv = document.createElement('div');
    app.modalStack = [];
    app.modalStackClearQueue = function () {
        if (app.modalStack.length) {
            (app.modalStack.shift())();
        }
    };
    app.modal = function (params) {
        params = params || {};
        var modalHTML = '';
        if (app.params.modalTemplate) {
            if (!app._compiledTemplates.modal) app._compiledTemplates.modal = t7.compile(app.params.modalTemplate);
            modalHTML = app._compiledTemplates.modal(params);
        }
        else {
            var buttonsHTML = '';
            if (params.buttons && params.buttons.length > 0) {
                for (var i = 0; i < params.buttons.length; i++) {
                    buttonsHTML += '<span class="modal-button' + (params.buttons[i].bold ? ' modal-button-bold' : '') + '">' + params.buttons[i].text + '</span>';
                }
            }
            var titleHTML = params.title ? '<div class="modal-title">' + params.title + '</div>' : '';
            var textHTML = params.text ? '<div class="modal-text">' + params.text + '</div>' : '';
            var afterTextHTML = params.afterText ? params.afterText : '';
            var noButtons = !params.buttons || params.buttons.length === 0 ? 'modal-no-buttons' : '';
            var verticalButtons = params.verticalButtons ? 'modal-buttons-vertical' : '';
            modalHTML = '<div class="modal ' + noButtons + ' ' + (params.cssClass || '') + '"><div class="modal-inner">' + (titleHTML + textHTML + afterTextHTML) + '</div><div class="modal-buttons ' + verticalButtons + '">' + buttonsHTML + '</div></div>';
        }

        _modalTemplateTempDiv.innerHTML = modalHTML;

        var modal = $(_modalTemplateTempDiv).children();

        $('body').append(modal[0]);

        // Add events on buttons
        modal.find('.modal-button').each(function (index, el) {
            $(el).on('click', function (e) {
                if (params.buttons[index].close !== false) app.closeModal(modal);
                if (params.buttons[index].onClick) params.buttons[index].onClick(modal, e);
                if (params.onClick) params.onClick(modal, index);
            });
        });
        app.openModal(modal);
        return modal[0];
    };

    app.alert = function (text, title, callbackOk) {
        if (typeof title === 'function') {
            callbackOk = arguments[1];
            title = undefined;
        }
        return app.modal({
            text: text || '',
            title: typeof title === 'undefined' ? app.params.modalTitle : title,
            buttons: [ {text: app.params.modalButtonOk, bold: true, onClick: callbackOk} ]
        });
    };
    app.confirm = function (text, title, callbackOk, callbackCancel) {
        if (typeof title === 'function') {
            callbackCancel = arguments[2];
            callbackOk = arguments[1];
            title = undefined;
        }
        return app.modal({
            text: text || '',
            title: typeof title === 'undefined' ? app.params.modalTitle : title,
            buttons: [
                {text: app.params.modalButtonCancel, onClick: callbackCancel},
                {text: app.params.modalButtonOk, bold: true, onClick: callbackOk}
            ]
        });
    };
    app.prompt = function (text, title, callbackOk, callbackCancel) {
        if (typeof title === 'function') {
            callbackCancel = arguments[2];
            callbackOk = arguments[1];
            title = undefined;
        }
        return app.modal({
            text: text || '',
            title: typeof title === 'undefined' ? app.params.modalTitle : title,
            afterText: '<div class="input-field"><input type="text" class="modal-text-input"></div>',
            buttons: [
                {
                    text: app.params.modalButtonCancel
                },
                {
                    text: app.params.modalButtonOk,
                    bold: true
                }
            ],
            onClick: function (modal, index) {
                if (index === 0 && callbackCancel) callbackCancel($(modal).find('.modal-text-input').val());
                if (index === 1 && callbackOk) callbackOk($(modal).find('.modal-text-input').val());
            }
        });
    };
    app.modalLogin = function (text, title, callbackOk, callbackCancel) {
        if (typeof title === 'function') {
            callbackCancel = arguments[2];
            callbackOk = arguments[1];
            title = undefined;
        }
        return app.modal({
            text: text || '',
            title: typeof title === 'undefined' ? app.params.modalTitle : title,
            afterText: '<div class="input-field modal-input-double"><input type="text" name="modal-username" placeholder="' + app.params.modalUsernamePlaceholder + '" class="modal-text-input"></div><div class="input-field modal-input-double"><input type="password" name="modal-password" placeholder="' + app.params.modalPasswordPlaceholder + '" class="modal-text-input"></div>',
            buttons: [
                {
                    text: app.params.modalButtonCancel
                },
                {
                    text: app.params.modalButtonOk,
                    bold: true
                }
            ],
            onClick: function (modal, index) {
                var username = $(modal).find('.modal-text-input[name="modal-username"]').val();
                var password = $(modal).find('.modal-text-input[name="modal-password"]').val();
                if (index === 0 && callbackCancel) callbackCancel(username, password);
                if (index === 1 && callbackOk) callbackOk(username, password);
            }
        });
    };
    app.modalPassword = function (text, title, callbackOk, callbackCancel) {
        if (typeof title === 'function') {
            callbackCancel = arguments[2];
            callbackOk = arguments[1];
            title = undefined;
        }
        return app.modal({
            text: text || '',
            title: typeof title === 'undefined' ? app.params.modalTitle : title,
            afterText: '<div class="input-field"><input type="password" name="modal-password" placeholder="' + app.params.modalPasswordPlaceholder + '" class="modal-text-input"></div>',
            buttons: [
                {
                    text: app.params.modalButtonCancel
                },
                {
                    text: app.params.modalButtonOk,
                    bold: true
                }
            ],
            onClick: function (modal, index) {
                var password = $(modal).find('.modal-text-input[name="modal-password"]').val();
                if (index === 0 && callbackCancel) callbackCancel(password);
                if (index === 1 && callbackOk) callbackOk(password);
            }
        });
    };
    app.showPreloader = function (title) {
        return app.modal({
            title: title || app.params.modalPreloaderTitle,
            text: '<div class="preloader">' + (app.params.material ? app.params.materialPreloaderSvg : '') + '</div>',
            cssClass: 'modal-preloader'
        });
    };
    app.hidePreloader = function () {
        app.closeModal('.modal.modal-in');
    };
    app.showIndicator = function () {
        $('body').append('<div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white">' + (app.params.material ? app.params.materialPreloaderSvg : '') + '</span></div>');
    };
    app.hideIndicator = function () {
        $('.preloader-indicator-overlay, .preloader-indicator-modal').remove();
    };
    // Action Sheet
    app.actions = function (target, params) {
        var toPopover = false, modal, groupSelector, buttonSelector;
        if (arguments.length === 1) {
            // Actions
            params = target;
        }
        else {
            // Popover
            if (app.device.ios) {
                if (app.device.ipad) toPopover = true;
            }
            else {
                if ($(window).width() >= 768) toPopover = true;
            }
        }
        params = params || [];

        if (params.length > 0 && !$.isArray(params[0])) {
            params = [params];
        }
        var modalHTML;
        if (toPopover) {
            var actionsToPopoverTemplate = app.params.modalActionsToPopoverTemplate ||
                '<div class="popover actions-popover">' +
                  '<div class="popover-inner">' +
                    '{{#each this}}' +
                    '<div class="list-block">' +
                      '<ul>' +
                        '{{#each this}}' +
                        '{{#if label}}' +
                        '<li class="actions-popover-label {{#if color}}color-{{color}}{{/if}} {{#if bold}}actions-popover-bold{{/if}}">{{text}}</li>' +
                        '{{else}}' +
                        '<li><a href="#" class="item-link list-button {{#if color}}color-{{color}}{{/if}} {{#if bg}}bg-{{bg}}{{/if}} {{#if bold}}actions-popover-bold{{/if}} {{#if disabled}}disabled{{/if}}">{{text}}</a></li>' +
                        '{{/if}}' +
                        '{{/each}}' +
                      '</ul>' +
                    '</div>' +
                    '{{/each}}' +
                  '</div>' +
                '</div>';
            if (!app._compiledTemplates.actionsToPopover) {
                app._compiledTemplates.actionsToPopover = t7.compile(actionsToPopoverTemplate);
            }
            var popoverHTML = app._compiledTemplates.actionsToPopover(params);
            modal = $(app.popover(popoverHTML, target, true));
            groupSelector = '.list-block ul';
            buttonSelector = '.list-button';
        }
        else {
            if (app.params.modalActionsTemplate) {
                if (!app._compiledTemplates.actions) app._compiledTemplates.actions = t7.compile(app.params.modalActionsTemplate);
                modalHTML = app._compiledTemplates.actions(params);
            }
            else {
                var buttonsHTML = '';
                for (var i = 0; i < params.length; i++) {
                    for (var j = 0; j < params[i].length; j++) {
                        if (j === 0) buttonsHTML += '<div class="actions-modal-group">';
                        var button = params[i][j];
                        var buttonClass = button.label ? 'actions-modal-label' : 'actions-modal-button';
                        if (button.bold) buttonClass += ' actions-modal-button-bold';
                        if (button.color) buttonClass += ' color-' + button.color;
                        if (button.bg) buttonClass += ' bg-' + button.bg;
                        if (button.disabled) buttonClass += ' disabled';
                        buttonsHTML += '<div class="' + buttonClass + '">' + button.text + '</div>';
                        if (j === params[i].length - 1) buttonsHTML += '</div>';
                    }
                }
                modalHTML = '<div class="actions-modal">' + buttonsHTML + '</div>';
            }
            _modalTemplateTempDiv.innerHTML = modalHTML;
            modal = $(_modalTemplateTempDiv).children();
            $('body').append(modal[0]);
            groupSelector = '.actions-modal-group';
            buttonSelector = '.actions-modal-button';
        }

        var groups = modal.find(groupSelector);
        groups.each(function (index, el) {
            var groupIndex = index;
            $(el).children().each(function (index, el) {
                var buttonIndex = index;
                var buttonParams = params[groupIndex][buttonIndex];
                var clickTarget;
                if (!toPopover && $(el).is(buttonSelector)) clickTarget = $(el);
                if (toPopover && $(el).find(buttonSelector).length > 0) clickTarget = $(el).find(buttonSelector);

                if (clickTarget) {
                    clickTarget.on('click', function (e) {
                        if (buttonParams.close !== false) app.closeModal(modal);
                        if (buttonParams.onClick) buttonParams.onClick(modal, e);
                    });
                }
            });
        });
        if (!toPopover) app.openModal(modal);
        return modal[0];
    };
    app.popover = function (modal, target, removeOnClose) {
        if (typeof removeOnClose === 'undefined') removeOnClose = true;
        if (typeof modal === 'string' && modal.indexOf('<') >= 0) {
            var _modal = document.createElement('div');
            _modal.innerHTML = modal.trim();
            if (_modal.childNodes.length > 0) {
                modal = _modal.childNodes[0];
                if (removeOnClose) modal.classList.add('remove-on-close');
                $('body').append(modal);
            }
            else return false; //nothing found
        }
        modal = $(modal);
        target = $(target);
        if (modal.length === 0 || target.length === 0) return false;
        if (modal.find('.popover-angle').length === 0 && !app.params.material) {
            modal.append('<div class="popover-angle"></div>');
        }
        modal.show();

        var material = app.params.material;

        function sizePopover() {
            modal.css({left: '', top: ''});
            var modalWidth =  modal.width();
            var modalHeight =  modal.height(); // 13 - height of angle
            var modalAngle, modalAngleSize = 0, modalAngleLeft, modalAngleTop;
            if (!material) {
                modalAngle = modal.find('.popover-angle');
                modalAngleSize = modalAngle.width() / 2;
                modalAngle.removeClass('on-left on-right on-top on-bottom').css({left: '', top: ''});
            }
            else {
                modal.removeClass('popover-on-left popover-on-right popover-on-top popover-on-bottom').css({left: '', top: ''});
            }

            var targetWidth = target.outerWidth();
            var targetHeight = target.outerHeight();
            var targetOffset = target.offset();
            var targetParentPage = target.parents('.page');
            if (targetParentPage.length > 0) {
                targetOffset.top = targetOffset.top - targetParentPage[0].scrollTop;
            }

            var windowHeight = $(window).height();
            var windowWidth = $(window).width();

            var modalTop = 0;
            var modalLeft = 0;
            var diff = 0;
            // Top Position
            var modalPosition = material ? 'bottom' : 'top';
            if (material) {
                if (modalHeight < windowHeight - targetOffset.top - targetHeight) {
                    // On bottom
                    modalPosition = 'bottom';
                    modalTop = targetOffset.top;
                }
                else if (modalHeight < targetOffset.top) {
                    // On top
                    modalTop = targetOffset.top - modalHeight + targetHeight;
                    modalPosition = 'top';
                }
                else {
                    // On middle
                    modalPosition = 'bottom';
                    modalTop = targetOffset.top;
                }

                if (modalTop <= 0) {
                    modalTop = 8;
                }
                else if (modalTop + modalHeight >= windowHeight) {
                    modalTop = windowHeight - modalHeight - 8;
                }

                // Horizontal Position
                modalLeft = targetOffset.left;
                if (modalLeft + modalWidth >= windowWidth - 8) {
                    modalLeft = targetOffset.left + targetWidth - modalWidth - 8;
                }
                if (modalLeft < 8) {
                    modalLeft = 8;
                }
                if (modalPosition === 'top') {
                    modal.addClass('popover-on-top');
                }
                if (modalPosition === 'bottom') {
                    modal.addClass('popover-on-bottom');
                }

            }
            else {
                if ((modalHeight + modalAngleSize) < targetOffset.top) {
                    // On top
                    modalTop = targetOffset.top - modalHeight - modalAngleSize;
                }
                else if ((modalHeight + modalAngleSize) < windowHeight - targetOffset.top - targetHeight) {
                    // On bottom
                    modalPosition = 'bottom';
                    modalTop = targetOffset.top + targetHeight + modalAngleSize;
                }
                else {
                    // On middle
                    modalPosition = 'middle';
                    modalTop = targetHeight / 2 + targetOffset.top - modalHeight / 2;
                    diff = modalTop;
                    if (modalTop <= 0) {
                        modalTop = 5;
                    }
                    else if (modalTop + modalHeight >= windowHeight) {
                        modalTop = windowHeight - modalHeight - 5;
                    }
                    diff = diff - modalTop;
                }

                // Horizontal Position
                if (modalPosition === 'top' || modalPosition === 'bottom') {
                    modalLeft = targetWidth / 2 + targetOffset.left - modalWidth / 2;
                    diff = modalLeft;
                    if (modalLeft < 5) modalLeft = 5;
                    if (modalLeft + modalWidth > windowWidth) modalLeft = windowWidth - modalWidth - 5;
                    if (modalPosition === 'top') {
                        modalAngle.addClass('on-bottom');
                    }
                    if (modalPosition === 'bottom') {
                        modalAngle.addClass('on-top');
                    }
                    diff = diff - modalLeft;
                    modalAngleLeft = (modalWidth / 2 - modalAngleSize + diff);
                    modalAngleLeft = Math.max(Math.min(modalAngleLeft, modalWidth - modalAngleSize * 2 - 6), 6);
                    modalAngle.css({left: modalAngleLeft + 'px'});

                }
                else if (modalPosition === 'middle') {
                    modalLeft = targetOffset.left - modalWidth - modalAngleSize;
                    modalAngle.addClass('on-right');
                    if (modalLeft < 5 || (modalLeft + modalWidth > windowWidth)) {
                        if (modalLeft < 5) modalLeft = targetOffset.left + targetWidth + modalAngleSize;
                        if (modalLeft + modalWidth > windowWidth) modalLeft = windowWidth - modalWidth - 5;
                        modalAngle.removeClass('on-right').addClass('on-left');
                    }
                    modalAngleTop = (modalHeight / 2 - modalAngleSize + diff);
                    modalAngleTop = Math.max(Math.min(modalAngleTop, modalHeight - modalAngleSize * 2 - 6), 6);
                    modalAngle.css({top: modalAngleTop + 'px'});
                }
            }


            // Apply Styles
            modal.css({top: modalTop + 'px', left: modalLeft + 'px'});
        }
        sizePopover();

        $(window).on('resize', sizePopover);
        modal.on('close', function () {
            $(window).off('resize', sizePopover);
        });

        app.openModal(modal);
        return modal[0];
    };
    app.popup = function (modal, removeOnClose) {
        if (typeof removeOnClose === 'undefined') removeOnClose = true;
        if (typeof modal === 'string' && modal.indexOf('<') >= 0) {
            var _modal = document.createElement('div');
            _modal.innerHTML = modal.trim();
            if (_modal.childNodes.length > 0) {
                modal = _modal.childNodes[0];
                if (removeOnClose) modal.classList.add('remove-on-close');
                $('body').append(modal);
            }
            else return false; //nothing found
        }
        modal = $(modal);
        if (modal.length === 0) return false;
        modal.show();

        app.openModal(modal);
        return modal[0];
    };
    app.pickerModal = function (pickerModal, removeOnClose) {
        if (typeof removeOnClose === 'undefined') removeOnClose = true;
        if (typeof pickerModal === 'string' && pickerModal.indexOf('<') >= 0) {
            pickerModal = $(pickerModal);
            if (pickerModal.length > 0) {
                if (removeOnClose) pickerModal.addClass('remove-on-close');
                $('body').append(pickerModal[0]);
            }
            else return false; //nothing found
        }
        pickerModal = $(pickerModal);
        if (pickerModal.length === 0) return false;
        pickerModal.show();
        app.openModal(pickerModal);
        return pickerModal[0];
    };
    app.loginScreen = function (modal) {
        if (!modal) modal = '.login-screen';
        modal = $(modal);
        if (modal.length === 0) return false;
        modal.show();

        app.openModal(modal);
        return modal[0];
    };
    app.openModal = function (modal) {
        modal = $(modal);
        var isModal = modal.hasClass('modal');
        if ($('.modal.modal-in:not(.modal-out)').length && app.params.modalStack && isModal) {
            app.modalStack.push(function () {
                app.openModal(modal);
            });
            return;
        }
        // do nothing if this modal already shown
        if (true === modal.data('f7-modal-shown')) {
            return;
        }
        modal.data('f7-modal-shown', true);
        modal.removeData('f7-modal-shown');
        // app.once('close', function() {
        //
        // });
        var isPopover = modal.hasClass('popover');
        var isPopup = modal.hasClass('popup');
        var isLoginScreen = modal.hasClass('login-screen');
        var isPickerModal = modal.hasClass('picker-modal');
        if (isModal) {
            modal.show();
            modal.css({
                marginTop: - Math.round(modal.outerHeight() / 2) + 'px'
            });
        }

        var overlay;
        if (!isLoginScreen && !isPickerModal) {
            if ($('.modal-overlay').length === 0 && !isPopup) {
                $('body').append('<div class="modal-overlay"></div>');
            }
            if ($('.popup-overlay').length === 0 && isPopup) {
                $('body').append('<div class="popup-overlay"></div>');
            }
            overlay = isPopup ? $('.popup-overlay') : $('.modal-overlay');
        }
        if (app.params.material && isPickerModal) {
            if (modal.hasClass('picker-calendar')) {
                if ($('.picker-modal-overlay').length === 0 && !isPopup) {
                    $('body').append('<div class="picker-modal-overlay"></div>');
                }
                overlay = $('.picker-modal-overlay');
            }
        }

        //Make sure that styles are applied, trigger relayout;
        var clientLeft = modal[0].clientLeft;

        // Trugger open event
        modal.trigger('open');

        // Picker modal body class
        if (isPickerModal) {
            $('body').addClass('with-picker-modal');
        }

        // Init Pages and Navbars in modal
        if (modal.find('.' + app.params.viewClass).length > 0) {
            modal.find('.page').each(function () {
                app.initPageWithCallback(this);
            });
            modal.find('.navbar').each(function () {
                app.initNavbarWithCallback(this);
            });
        }

        // Classes for transition in
        if (!isLoginScreen && !isPickerModal) overlay.addClass('modal-overlay-visible');
        if (app.params.material && isPickerModal && overlay) overlay.addClass('modal-overlay-visible');
        modal.removeClass('modal-out').addClass('modal-in').transitionEnd(function (e) {
            if (modal.hasClass('modal-out')) modal.trigger('closed');
            else modal.trigger('opened');
        });
        return true;
    };
    // app.once = function (eventName, targetSelector, listener, capture) {
    //     var dom = this;
    //     if (typeof targetSelector === 'function') {
    //         targetSelector = false;
    //         listener = arguments[1];
    //         capture = arguments[2];
    //     }
    //     function proxy(e) {
    //         listener(e);
    //         dom.off(eventName, targetSelector, proxy, capture);
    //     }
    //     dom.on(eventName, targetSelector, proxy, capture);
    // };

    app.transitionEnd = function (callback) {
        var events = ['webkitTransitionEnd', 'transitionend', 'oTransitionEnd', 'MSTransitionEnd', 'msTransitionEnd'],
            i, j, dom = this;
        function fireCallBack(e) {
            /*jshint validthis:true */
            if (e.target !== this) return;
            callback.call(this, e);
            for (i = 0; i < events.length; i++) {
                dom.off(events[i], fireCallBack);
            }
        }
        if (callback) {
            for (i = 0; i < events.length; i++) {
                dom.on(events[i], fireCallBack);
            }
        }
        return this;
    };

    app.closeModal = function (modal) {
        modal = $(modal || '.modal-in');
        if (typeof modal !== 'undefined' && modal.length === 0) {
            return;
        }
        var isModal = modal.hasClass('modal');
        var isPopover = modal.hasClass('popover');
        var isPopup = modal.hasClass('popup');
        var isLoginScreen = modal.hasClass('login-screen');
        var isPickerModal = modal.hasClass('picker-modal');

        var removeOnClose = modal.hasClass('remove-on-close');

        var overlay = isPopup ? $('.popup-overlay') : (isPickerModal && app.params.material ? $('.picker-modal-overlay') : $('.modal-overlay'));
        if (isPopup){
            if (modal.length === $('.popup.modal-in').length) {
                overlay.removeClass('modal-overlay-visible');
            }
        }
        else if (overlay && overlay.length > 0) {
            overlay.removeClass('modal-overlay-visible');
        }

        modal.trigger('close');

        // Picker modal body class
        if (isPickerModal) {
            $('body').removeClass('with-picker-modal');
            $('body').addClass('picker-modal-closing');
        }

        if (!(isPopover && !app.params.material)) {
            modal.removeClass('modal-in').addClass('modal-out').transitionEnd(function (e) {
                if (modal.hasClass('modal-out')) modal.trigger('closed');
                else modal.trigger('opened');

                if (isPickerModal) {
                    $('body').removeClass('picker-modal-closing');
                }
                if (isPopup || isLoginScreen || isPickerModal || isPopover) {
                    modal.removeClass('modal-out').hide();
                    if (removeOnClose && modal.length > 0) {
                        modal.remove();
                    }
                }
                else {
                    modal.remove();
                }
            });
            if (isModal && app.params.modalStack) {
                app.modalStackClearQueue();
            }
        }
        else {
            modal.removeClass('modal-in modal-out').trigger('closed').hide();
            if (removeOnClose) {
                modal.remove();
            }
        }
        return true;
    };
}
