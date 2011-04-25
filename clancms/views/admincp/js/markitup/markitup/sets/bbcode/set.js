// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2008 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
// BBCode tags example
// http://en.wikipedia.org/wiki/Bbcode
// ----------------------------------------------------------------------------
// Feel free to add more tags
// ----------------------------------------------------------------------------
mySettings = {
	previewParserPath:	'', // path to your BBCode parser
	markupSet: [
		{name:'Bold', className:"bold", key:'B', openWith:'[b]', closeWith:'[/b]'},
		{name:'Italic', className:"italic", key:'I', openWith:'[i]', closeWith:'[/i]'},
		{name:'Underline', className:"underline", key:'U', openWith:'[u]', closeWith:'[/u]'},
		{name:'Strike through', className:"strike_through", openWith:'[s]', closeWith:'[/s]'},
		{separator:'---------------' },
		{name:'Align Left', className:"align_left", openWith:'[left]', closeWith:'[/left]'},
		{name:'Align Center', className:"align_center", openWith:'[center]', closeWith:'[/center]'},
		{name:'Align Right', className:"align_right", openWith:'[right]', closeWith:'[/right]'},
		{separator:'---------------' },
		{name:'Super Script', className:"super_script", openWith:'[sup]', closeWith:'[/sup]'},
		{name:'Sub Script', className:"sub_script", openWith:'[sub]', closeWith:'[/sub]'},
		{separator:'---------------' },
		{name:'Uppercase', className:"uppercase", openWith:'[upper]', closeWith:'[/upper]'},
		{name:'Lowercase', className:"lowercase", openWith:'[lower]', closeWith:'[/lower]'},
		{separator:'---------------' },
		{name:'Picture', className:"picture", key:'P', replaceWith:'[img][![Url:!:http://]!][/img]'},
		{name:'Link', className:"link", key:'L', openWith:'[url=[![Url:!:http://]!]]', closeWith:'[/url]', placeHolder:'[![Text]!]'},
		{name:'Email', className:"email", key:'E', openWith:'[email=[![Email]!]]', closeWith:'[/email]', placeHolder:'[![Text]!]'},
		{separator:'---------------' },
		{name:'Size', className:"size", key:'S', openWith:'[size=[![Text size]!]]', closeWith:'[/size]',
		dropMenu :[
			{name:'Big', openWith:'[size=200]', closeWith:'[/size]' },
			{name:'Normal', openWith:'[size=100]', closeWith:'[/size]' },
			{name:'Small', openWith:'[size=50]', closeWith:'[/size]' }
		]},
		{name:'Colors', 
			className:'colors', 
			openWith:'[color=[![Color]!]]', 
			closeWith:'[/color]', 
				dropMenu: [
					{name:'Yellow',	openWith:'[color=yellow]', 	closeWith:'[/color]', className:"col1-1" },
					{name:'Orange',	openWith:'[color=orange]', 	closeWith:'[/color]', className:"col1-2" },
					{name:'Red', 	openWith:'[color=red]', 	closeWith:'[/color]', className:"col1-3" },
					
					{name:'Blue', 	openWith:'[color=blue]', 	closeWith:'[/color]', className:"col2-1" },
					{name:'Purple', openWith:'[color=purple]', 	closeWith:'[/color]', className:"col2-2" },
					{name:'Green', 	openWith:'[color=green]', 	closeWith:'[/color]', className:"col2-3" },
					
					{name:'White', 	openWith:'[color=white]', 	closeWith:'[/color]', className:"col3-1" },
					{name:'Gray', 	openWith:'[color=gray]', 	closeWith:'[/color]', className:"col3-2" },
					{name:'Black',	openWith:'[color=black]', 	closeWith:'[/color]', className:"col3-3" }
				]
		},
		{separator:'---------------' },
		{name:'Bulleted list', className:"bulleted_list", openWith:'[list]\n', closeWith:'\n[/list]'},
		{name:'Numeric list', className:"numeric_list", openWith:'[list=[![Starting number]!]]\n', closeWith:'\n[/list]'}, 
		{name:'List item', className:"list_item", openWith:'[*] '},
		{separator:'---------------' },
		{name:'Quotes', className:"quotes", openWith:'[quote]', closeWith:'[/quote]'},
		{name:'Code', className:"code", openWith:'[code]', closeWith:'[/code]'}, 
		{name:'Date of the Day', 
			className:"dateoftheday", 
			replaceWith:function(h) { 
				date = new Date()
				weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
				monthname = ["January","February","March","April","May","June","July","August","September","October","November","December"];
				D = weekday[date.getDay()];
				d = date.getDate();
				m = monthname[date.getMonth()];
				y = date.getFullYear();
				h = date.getHours();
				i = date.getMinutes();
				s = date.getSeconds();
				return (D +" "+ d + " " + m + " " + y + " " + h + ":" + i + ":" + s);
			}
		},
		{separator:'---------------' },
		{name:'Youtube', className:"youtube", openWith:'[youtube]', closeWith:'[/youtube]', placeHolder:'[![Youtube Video ID]!]'},
		{name:'Happy', className:"happy", replaceWith:function(markitup) { return ':happy:'; }},
		{name:'Sad', className:"sad", replaceWith:function(markitup) { return ':sad:'; }},
		{name:'Surprised', className:"surprised", replaceWith:function(markitup) { return ':surprised:'; }},
		{name:'Tongue', className:"tongue", replaceWith:function(markitup) { return ':tongue:'; }},
		{name:'Wink', className:"wink", replaceWith:function(markitup) { return ':wink:'; }},
		{name:'Smile', className:"smile", replaceWith:function(markitup) { return ':smile:'; }},
		{name:'Curly Lips', className:"curlylips", replaceWith:function(markitup) { return ':curly:'; }},
		{name:'Evil Grin', className:"evilgrin", replaceWith:function(markitup) { return ':evil:'; }},
		{name:'Heart', className:"heart", replaceWith:function(markitup) { return ':heart:'; }}
	]
}