/*

created by Unknow

modified by introtik

Mohammed Ahmed: maa@intro.ps

22/May/2012
*/

(function(){CKEDITOR.dialog.add('mp3player',
	function(editor)
	{return{title:editor.lang.mp3player.title,minWidth:CKEDITOR.env.ie&&CKEDITOR.env.quirks?368:350,minHeight:240,
	onShow:function(){this.getContentElement('general','content').getInputElement().setValue('')},
	onOk:function(){
		       		val = this.getContentElement('general','content').getInputElement().getValue();
					var text='<object type="application/x-shockwave-flash" data="player_mp3.swf" width="200" height="20">'
							+'	<param name="movie" value="player_mp3.swf" />'
							+'	<param name="bgcolor" value="#ffffff" />'
							+'	<param name="FlashVars" value="mp3='+escape(val)+'&amp;autoplay=0" />'
							+'</object>';
	this.getParentEditor().insertHtml(text)},
	contents:[{label:editor.lang.common.generalTab,id:'general',elements:
																		[{type:'html',id:'pasteMsg',html:'<div style="white-space:normal;width:500px;"><img style="margin:5px auto;" src="'
																		+CKEDITOR.getUrl(CKEDITOR.plugins.getPath('mp3player')
																		+'images/mp3_large.png')
																		+'"><br />'+editor.lang.mp3player.pasteMsg
																		+'</div>'},{type:'html',id:'content',style:'width:340px;height:90px',html:'<input size="100" style="'+'border:1px solid black;'+'background:white">',focus:function(){this.getElement().focus()}}]}]}})})();
