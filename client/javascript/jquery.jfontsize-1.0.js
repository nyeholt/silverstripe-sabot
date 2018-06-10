/*
 * jQuery jFontSize Plugin
 * Examples and documentation: http://jfontsize.com
 * Author: Frederico Soares Vanelli
 *         fredsvanelli@gmail.com
 *         http://twitter.com/fredvanelli
 *         http://facebook.com/fred.vanelli
 *
 * Copyright (c) 2011
 * Version: 1.0 (2011-07-13)
 * Dual licensed under the MIT and GPL licenses.
 * http://jfontsize.com/license
 * Requires: jQuery v1.2.6 or later
 */

(function($){
    $.fn.jfontsize = function(opcoes) {
        var $this=$(this);
      var defaults = {
        btnMinusClasseId: '#jfontsize-minus',
        btnDefaultClasseId: '#jfontsize-default',
        btnPlusClasseId: '#jfontsize-plus',
            btnMinusMaxHits: 10,
            btnPlusMaxHits: 10,
            sizeChange: 1
      };

      opcoes = $.extend(defaults, opcoes);

        var limite=new Array();
        var fontsize_padrao=new Array();

        $(this).each(function(i){
            limite[i]=0;
            fontsize_padrao[i];
        })
    var allItems = opcoes.btnMinusClasseId + ',' + opcoes.btnDefaultClasseId  + ',' + opcoes.btnPlusClasseId;
    
        $(allItems).click(function (e) { e.preventDefault() });
        $(allItems).css('cursor', 'pointer');

        $(opcoes.btnMinusClasseId).click(function(){
            $this.each(function(i){
                if (limite[i]>(-(opcoes.btnMinusMaxHits))){
                    fontsize_padrao[i]=$(this).css('font-size');
                    fontsize_padrao[i]=fontsize_padrao[i].replace('px', '');
                    var fontsize=$(this).css('font-size');
                    fontsize=parseInt(fontsize.replace('px', ''));
                    fontsize=fontsize-(opcoes.sizeChange);
                    fontsize_padrao[i]=fontsize_padrao[i]-(limite[i]*opcoes.sizeChange);
                    limite[i]--;
                    $(this).css('font-size', fontsize+'px');
                }
            })
        })

        
        $(opcoes.btnDefaultClasseId).click(function(){
            $this.each(function(i){
                limite[i]=0;
                $(this).css('font-size', fontsize_padrao[i]+'px');
            })
        })

        $(opcoes.btnPlusClasseId).click(function(){
            $this.each(function(i){
                if (limite[i]<opcoes.btnPlusMaxHits){
                    fontsize_padrao[i]=$(this).css('font-size');
                    fontsize_padrao[i]=fontsize_padrao[i].replace('px', '');
                    var fontsize=$(this).css('font-size');
                    fontsize=parseInt(fontsize.replace('px', ''));
                    fontsize=fontsize+opcoes.sizeChange;
                    fontsize_padrao[i]=fontsize_padrao[i]-(limite[i]*opcoes.sizeChange);
                    limite[i]++;
                    $(this).css('font-size', fontsize+'px');
                }
            })
        })
    };
})(jQuery);