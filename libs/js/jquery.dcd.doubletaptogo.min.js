/*
 Original Plugin by Osvaldas Valutis, www.osvaldas.info
 http://osvaldas.info/drop-down-navigation-responsive-and-touch-friendly
 Available for use under the MIT License
 */
/**
 * jquery-doubleTapToGo plugin
 * Copyright 2017 DACHCOM.DIGITAL AG
 * @author Marco Rieser
 * @author Volker Andres
 * @author Stefan Hagspiel
 * @version 3.0.2
 * @see https://github.com/dachcom-digital/jquery-doubletaptogo
 */
!function(t,e,s,i){"use strict";function n(e,s){this.element=e,this.settings=t.extend({},a,s),this._defaults=a,this._name=o,this.init()}var o="doubleTapToGo",a={automatic:!0,selectorClass:"doubletap",selectorChain:"li:has(ul)"};t.extend(n.prototype,{preventClick:!1,currentTap:t(),init:function(){t(this.element).on("touchstart","."+this.settings.selectorClass,this._tap.bind(this)).on("click","."+this.settings.selectorClass,this._click.bind(this)).on("remove",this._destroy.bind(this)),this._addSelectors()},_addSelectors:function(){this.settings.automatic===!0&&t(this.element).find(this.settings.selectorChain).addClass(this.settings.selectorClass)},_click:function(e){this.preventClick?e.preventDefault():this.currentTap=t()},_tap:function(e){var s=t(e.target).closest("li");return s.hasClass(this.settings.selectorClass)?s.get(0)===this.currentTap.get(0)?void(this.preventClick=!1):(this.preventClick=!0,this.currentTap=s,void e.stopPropagation()):void(this.preventClick=!1)},_destroy:function(){t(this.element).off()},reset:function(){this.currentTap=t()}}),t.fn[o]=function(e){var s,a=arguments;return e===i||"object"==typeof e?this.each(function(){t.data(this,o)||t.data(this,o,new n(this,e))}):"string"==typeof e&&"_"!==e[0]&&"init"!==e?(this.each(function(){var i=t.data(this,o),r="destroy"===e?"_destroy":e;i instanceof n&&"function"==typeof i[r]&&(s=i[r].apply(i,Array.prototype.slice.call(a,1))),"destroy"===e&&t.data(this,o,null)}),s!==i?s:this):void 0}}(jQuery,window,document);