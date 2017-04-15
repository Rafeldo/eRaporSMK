/*

created by Unknow

modified by introtik

Mohammed Ahmed: maa@intro.ps

22/May/2012
*/

(function(){var youtubeCmd={exec:function(editor){editor.openDialog('youtube');return}};
CKEDITOR.plugins.add('youtube',{lang:['en','ar'],requires:['dialog'],
	init:function(editor){var commandName='youtube';editor.addCommand(commandName,youtubeCmd);
				editor.ui.addButton('Youtube',{label:editor.lang.youtube.button,command:commandName,icon:this.path+"images/youtube.png"});
				CKEDITOR.dialog.add(commandName,CKEDITOR.getUrl(this.path+'dialogs/youtube.js'))}})})();
/*
 Mohammed Ahmed
 IntroTik
 Gaza, Palestine
 Email: maa@intro.ps
 Mobile: +970598505800
 Tel: +97082884379
 */