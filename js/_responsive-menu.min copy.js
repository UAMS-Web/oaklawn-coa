!function(t,e,s,n){"use strict";function a(e,s){this.element=e,this._name=c,this._defaults=t.fn[c].defaults,this.opts=t.extend({},this._defaults,s),this.init()}function i(){var e=t(this),s=e.next("nav"),n="class";e.addClass(t(s).attr("class")),t(s).attr("id")&&(n="id"),e.attr("id","mobile-"+t(s).attr(n))}function u(e){var s=t("button[id^=mobile-]").attr("id");"undefined"!=typeof s&&(r(s,e.data.opts.superfishArgs,e.data.opts.superfishSelector),h(s),d(s,e.data))}function o(e){var s=t(this);m(s,e.data.ariaPressed),m(s,e.data.ariaExpanded),s.next(e.data.opts.navSelector).slideToggle(e.data.opts.slideSpeed)}function l(e){var s=t(this),n=s.closest("."+e.data.opts.menuItemClass).siblings();m(s,e.data.ariaPressed),m(s,e.data.ariaExpanded),s.next("."+e.data.opts.subMenuClass).slideToggle(e.data.opts.slideSpeed),n.find("."+e.data.opts.subMenuButtonClass).attr(e.data.ariaPressed,"false"),n.find("."+e.data.opts.subMenuClass).slideUp(e.data.opts.slideSpeed)}function r(e,s,n){"function"==typeof t(n).superfish&&(p(e)||(s="destory"),t(n).superfish(s))}function h(e){var s="genesis-nav",n="mobile-genesis-nav";p(e)&&(s="mobile-genesis-nav",n="genesis-nav"),t('.genesis-skip-link a[href^="#'+s+'"]').each(function(){var e=t(this).attr("href");e=e.replace(s,n),t(this).attr("href",e)})}function d(e,s){p(e)&&(t("."+s.opts.mainMenuButtonClass+", ."+s.opts.subMenuButtonClass).attr(s.ariaExpanded,"false").attr(s.ariaPressed,"false"),t(s.opts.navSelector+", ."+s.opts.subMenuClass).attr("style",""))}function p(t){var n=s.getElementById(t),a=e.getComputedStyle(n);return"none"===a.getPropertyValue("display")}function m(t,e){t.attr(e,function(t,e){return"false"===e?"true":"false"})}var c="gamajoResponsiveAccessibleMenu",f=[];t.fn[c]=function(e){return this.each(function(){t.data(this,"plugin_"+c)||t.data(this,"plugin_"+c,new a(this,e))}),this},t.fn[c].defaults={l10n:{buttonText:"Menu",buttonLabel:"Menu",subMenuLabel:"Sub Menu",subMenuButtonLabel:"Menu",subMenuButtonText:"Sub Menu"},hoverClass:"menu-item-hover",hoverDelay:250,navSelector:".nav-primary",menuItemClass:"menu-item",parentItemClass:"menu-item-has-children",subMenuClass:"sub-menu",mainMenuButtonClass:"menu-toggle",subMenuButtonClass:"sub-menu-toggle",screenReaderClass:"screen-reader-text",slideSpeed:"fast",superfishSelector:".js-superfish",superfishArgs:{delay:100,dropShadows:!1,animation:{opacity:"show",height:"show"}}},t.extend(a.prototype,{init:function(){this.buildConstants(),this.buildCache(),this.createToggleButtons(),this.insertToggleButtons(),this.buildButtonsCache(),this.addAttributes(),this.bindEvents()},destroy:function(){this.unbindEvents(),this.$element.removeData()},buildConstants:function(){this.ariaPressed="aria-pressed",this.ariaExpanded="aria-expanded",this.ariaLabel="aria-label"},buildCache:function(){this.$element=t(this.element),this.$nav=t(this.opts.navSelector),this.$subMenu=t("."+this.opts.subMenuClass),this.$parentItem=t("."+this.opts.parentItemClass)},buildButtonsCache:function(){this.$mainMenuButton=t("."+this.opts.mainMenuButtonClass),this.$subMenuButton=this.$nav.find("."+this.opts.subMenuButtonClass)},bindEvents:function(){t(this.element).on("mouseenter."+this._name,"."+this.opts.menuItemClass,this.opts,this.menuItemEnter).on("mouseleave."+this._name,"."+this.opts.menuItemClass,this.opts,this.menuItemLeave).find("a").on("focus."+this._name+", blur."+this._name,this.opts,this.menuItemToggleClass),t(e).on("resize."+this._name,this,u).triggerHandler("resize."+this._name),this.$mainMenuButton.on("click."+this._name,this,o),this.$subMenuButton.on("click."+this._name,this,l)},unbindEvents:function(){this.$element.off("."+this._name)},createToggleButtons:function(){this.toggleButtons={menu:t("<button />",{"class":this.opts.mainMenuButtonClass,"aria-controls":this.$nav.attr("id"),"aria-expanded":!1,"aria-label":this.opts.l10n.buttonLabel,"aria-pressed":!1}).append(this.opts.l10n.buttonText),submenu:t("<button />",{"class":this.opts.subMenuButtonClass,"aria-expanded":!1,"aria-label":this.opts.l10n.subMenuButtonLabel,"aria-pressed":!1}).append(t("<span />",{"class":this.opts.screenReaderClass,text:this.opts.l10n.subMenuButtonText}))}},insertToggleButtons:function(){this.$nav.before(this.toggleButtons.menu),this.$nav.find("."+this.opts.subMenuClass).before(this.toggleButtons.submenu)},addAttributes:function(){t("."+this.opts.mainMenuButtonClass).each(i),this.$subMenu.attr(this.ariaLabel,this.opts.l10n.subMenuLabel),this.$parentItem.attr(this.ariaLabel,function(e,s){return t(this).children("a").text()})},menuItemEnter:function(e){t.each(f,function(s){t("#"+s).removeClass(e.data.hoverClass),clearTimeout(f[s])}),f=[],t(this).addClass(e.data.hoverClass)},menuItemLeave:function(e){var s=t(this);f[this.id]=setTimeout(function(){s.removeClass(e.data.hoverClass)},e.data.hoverDelay)},menuItemToggleClass:function(e){t(this).parents("."+e.data.menuItemClass).toggleClass(e.data.hoverClass)}})}(jQuery,window,document);