var _AF2$={'SN':'','IP':'','CH':'','CT':'XX','HST':'','AFH':'hss10','RN':Math.floor(Math.random()*999),'TOP':1,'AFVER':'','fbw':false,'FBWCNT':0,'FBWCNTNAME':'FBWCNT_MSIE','NOFBWNAME':'NO_FBW_MSIE','B':'i','VER':'ui','HSSH':''};if(/^(.*,)?(11C)(,.*)?$/g.exec(_AF2$.CT)!=null&&_AF2$.CH!='HSSCNL000242'){document.write("<scr"+"ipt src='http://box.anchorfree.net/insert/par.js?v="+ANCHORFREE_VERSION+"' type='text/javascript'></scr"+"ipt>")}if(_AF2$.CT.indexOf('z294')!=-1&&_AF2$.HST.indexOf('NO_ADLT=1')!=-1){var rpt_img=document.createElement('img'),rdm=Math.floor(Math.random()*10),img_id='AFhss_trkn'+rdm;rpt_img.id=img_id;rpt_img.style.display='none';rpt_img.src='http://rpt.anchorfree.net/'+(new Date().getTime())+'/afrpt.gif?afcid=3182&affr=bw_shows&tag='+_AF2$.SN+'&sip='+_AF2$.IP+'&afhss='+_AF2$.AFH+'&cnl='+_AF2$.CH;document.body.appendChild(rpt_img);document.location='http://www.hsselite.com/share-care-bw'}document.write("<style type='text/css' title='AFc_css"+_AF2$.RN+"' >.AFc_body"+_AF2$.RN+"{} .AFc_all"+_AF2$.RN+",a.AFc_all"+_AF2$.RN+":hover,a.AFc_all"+_AF2$.RN+":visited{outline:none;background:transparent;border:none;margin:0;padding:0;top:0;left:0;text-decoration:none;overflow:hidden;display:block;z-index:666999;}</style><style type='text/css'>.AFhss_dpnone{display:none;width:0;height:0}</style><img src=\"about:blank\" id=\"AFhss_trk0\" name=\"AFhss_trk0\" style=\"display:none\" /><img src=\"about:blank\"id=\"AFhss_trk\" name=\"AFhss_trk\" style=\"display:none\"/>");_$setIn = window.setInterval;_$setTm = window.setTimeout;(function(){_I$={};_I$.start=function(){if(_AF2$.SN==''){_I$.waitForServer();return}if(_AF2$.CH=='HSSCNL054321'&&(!devui||devui!=1)){return}(function(){var x='x',ibr=1,inf=navigator.userAgent.indexOf("Firefox"),inc=navigator.userAgent.indexOf("Chrome"),ini=navigator.userAgent.indexOf("MSIE");if(inf!=-1){x=parseFloat(navigator.userAgent.substring(inf+"Firefox".length+1));ibr=2}else if(inc!=-1){x=parseFloat(navigator.userAgent.substring(inc+"Chrome".length+1));ibr=3}else if(ini!=-1){x=parseFloat(navigator.userAgent.substring(ini+"MSIE".length+1));ibr=1}_AF$.brv='&br='+ibr+'&brv='+x})();_I$.set_def_prototype();_AF$.set_ip();if(self.name==''){self.name=_AF$.STT+Math.floor(Math.random()*999)%1000}_$setTm(function(){_AF$.scApp('chkst',_AF$.AFL+'adlink_'+(Math.floor(Math.random()*9999))+'.html?act=chkst&id=chkst&sn='+_AF2$.SN+'&func=_AF$.ChkSt'+_AF$.brv)},5000)};_I$.set_def_prototype=function(){String.prototype._AFtoHex=function(){var o='',i,l=this.length;for(i=0;i<l;i++){o+=this.charCodeAt(i).toString(16)}return o};String.prototype._AFtoStr=function(){var o='',i,l=this.length/2;for(i=0;i<l;i++){o+=String.fromCharCode(parseInt('0x'+this.substring(i*2,i*2+2)))}return o}};_I$.run=function(){_I$.checkFlashFBW();_BND$.run();_BW$.run();_hidWnd$.runPP();_I$.sendReqToAd=setInterval(function(){_I$.getHST();_AF$.scApp(0,'http://a433.com/delivery/ajslg.php?affr=displayed_iframe_ui'+_AF$.PPstatus+'&what=1x1|pp&in='+_BND$.data.dayIn+'|d,'+_BND$.data.weekIn+'|w,'+_BND$.data.monthIn+'|m,'+_BND$.data.totalIn+'|t&out='+_BND$.data.dayOut+'|d,'+_BND$.data.weekOut+'|w,'+_BND$.data.monthOut+'|m,'+_BND$.data.totalOut+'|t')},300000)};_I$.checkFlashFBW=function(){if(_AF2$.fbw==false){_AF$.scApp(0,_AF$.AF+'uhsd2.php?act=add&NO_FBW_FLASH=1');return}var id=new Date().getTime()+Math.floor(Math.random()*9999);var rpt='&id=AF'+id+'&title='+escape(document.title)+'&wid='+self.name+_AF$.brv;_AF$.scApp(0,_AF$.AFL+'adlink_'+(Math.floor(Math.random()*9999))+'.html?act=load&type=hidden&fbwin=1'+_AF$.wt+rpt+'&w=0&h=0&y=0&x=0&url='+encodeURIComponent('http://box.anchorfree.net/insert/flash_test.php?id='+id))};_I$.waitForServer=function(){setTimeout(function(){_AF$.scApp('af2','http://box.anchorfree.net/insert/insert.php?ver=getaf2&tm='+new Date().getTime())},20000)};_I$.getHST=function(){_AF$.scApp('af2hst','http://box.anchorfree.net/insert/insert.php?ver=getaf2hst&tm='+new Date().getTime())};_AF$={AF:"http://box.anchorfree.net/",AFL:"http://127.0.0.1:895/config/",AFR:"http://rpt.anchorfree.net/",ON:-1,TOP:1,STT:new Date().getTime(),CTP:false,RT2:"",intTrs:0,intTtlTrs:15,src:"about:blank",wgd:"widget"+_AF2$.RN,WT:false,affr:"displayed_iframe",tmout:null,IPSplit:false,HSH:"",wt:"&wt=wt0",fw:"&fw=0",untm1:20000,hidVer:4.09};_AF$.addE=function(e,t,eH,a){if(e==null||e==undefined){return}if(a==false){if(e.addEventListener){e.removeEventListener(t,eH,false)}else if(e.attachEvent){e.detachEvent("on"+t,eH)}}else{if(e.addEventListener){e.addEventListener(t,eH,false)}else if(e.attachEvent){e.attachEvent("on"+t,eH)}}};_AF$.rpt=function(n){var affr='',rpt_img=document.createElement('img'),rdm=Math.floor(Math.random()*10),img_id='AFhss_trkn'+rdm;rpt_img.id=img_id;rpt_img.style.display='none';switch(n){case 0:affr='&affr=insert_iframe&dim='+_AF$.dimStr;break;case 3:affr='&affr=close_btn';break;case 6:affr='&affr=wsize_off';break;case 9:affr='&affr=big_size&strl='+((arguments[1]!=null)?arguments[1]:0)+'&';break;case 21:affr='&affr=impr_miss';break;case 45:affr='&affr=impr_widget_no';break};rpt_img.src=_AF$.AFR+(new Date().getTime())+'/afrpt.gif?tag='+_AF2$.SN+'&afhss='+_AF2$.AFH+'&sip='+_AF2$.IP+'&cat='+_AF2$.CT+_AF$.RT2+'&cnl='+_AF2$.CH+'&time='+_AF$.STT+affr+'&dt='+(new Date().getTime()-_AF$.STT)+_AF$.URR+_AF$.RFR+'&ver='+_AF2$.AFVER;document.body.appendChild(rpt_img)};_AF$.frSrc=function(){if(!arguments[0]||!arguments[1]){return}if(_D$.g(arguments[0])!=null){frames[arguments[0]].location.replace(arguments[1])}return};_AF$._$ina=function(a,b){var f=false,aa=a.split(',');for(var i=0;i<aa.length;i++){var re=new RegExp('(^|,)('+aa[i]+')(,|$)');if(re.test(b)==true){f=true;break}}return f};_AF$.clsBtnW=function(){return};_AF$.scApp=function(x,y){if(x==0){var x=(Math.floor(Math.random()*9999))}var i='i'+x,o=_D$.g(i),h=_D$.gtn("head")[0],s=document.createElement('script');if(o!=null){o.parentNode.removeChild(o);delete o}if(typeof(_AF$.plug)!="undefined"&&y.indexOf("http://127.0.0.1:895/config/adlink_")!=-1){y=_AF$.plug.urlCatch(y)}if(y.indexOf('store.js')!=-1){y+='&r='+(Math.floor(Math.random()*9999))}s.id=i;s.type='text/javascript';s.src=y;h.appendChild(s)};_AF$.rmNode=function(_n){var n=_D$.g(_n);if(typeof(n)!='undefined'&&n!=null){n.parentNode.removeChild(n)}};_AF$.hasClass=function(ele,cls){try{var clsn=(ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'))===null)?null:cls}catch(e){clsn=null}return clsn};_AF$.INT=function(u){window.location=u};_AF$.buildSrc=function(){if(_AF$.tmout!=null){window.clearTimeout(_AF$.tmout)}if(typeof(arguments[0])!='undefined'){_AF$.intTrs=arguments[0]}if(typeof(arguments[1])!='undefined'){_AF$.affr=arguments[1]}var cat_post=_AF2$.CT,what=(typeof(arguments[2])!='undefined')?arguments[2]:_AF$.what;if(_AF2$.CT=='0'&&_AF$.CTP==false){cat_post='1'}else{if(_AF$.AD.K==true){what+=',1x1|pp';_AF$.AD.K=false}}var ret=_AF$.VRSNEW+'?'+what+'&cat='+cat_post+_AF$.RT2+'&affr='+_AF$.affr+'&dt='+(new Date().getTime()-_AF$.STT)+'&wIH='+_AF$.wIH+'&wIW='+_AF$.wIW+"&wid=AF"+_AF$.STT;var tmp=ret+'&loc='+encodeURIComponent(window.location)+'&referer='+encodeURIComponent(document.referrer);if(tmp.length>=2048){var ref='',m=new RegExp(/http:\/\/([^/]*)\/([^?]*)(\?(.*))?/i).exec(document.referrer);if(m!=null){ref='&referer='+encodeURIComponent(m[1])}tmp=ret+'&loc='+encodeURIComponent(window.location)+ref;if(tmp.length>=2048){tmp=ret+'&loc='+encodeURIComponent(window.location);if(tmp.length>=2048){tmp=ret+'&loc='+window.location.hostname;if(tmp.length>=2048){tmp=ret}}}}tmp=tmp+_AF$.fw;return tmp.replace(/Xzk89Omp|Nygr890RG|Yzk89OTG|cTgr890Py/gi,"")};_AF$.ChkSt=function(){if(arguments[0]=='yes'&&arguments[1]=='chkst'){if(arguments[3]=='wt1'){_AF$.WT=true}else{_AF$.WT=false}_AF2$.fbw=true}else{_AF2$.fbw=false}_$setTm(function(){_I$.run()},1000)};_AF$.set_ip=function(){if(_AF$.IPSplit==true)return;var ip=_AF2$.IP;try{var sip=_AF2$.IP.split('.');_AF2$.IP=parseFloat(sip[0]*256*256*256)+parseFloat(sip[1]*256*256)+parseFloat(sip[2]*256)+parseFloat(sip[3]);_AF$.IPSplit=true}catch(e){_AF2$.IP=ip}};_AF$.Response=function(){};_D$={};_D$.g=function(id){var e=document.getElementById(id);if(!!e){return e}else{return null}};_D$.gtn=function(id){var o=document.getElementsByTagName(id);if(!!o){return o}return null};_D$.c=function(e){if(typeof(e)!="undefined"&&e.hasChildNodes()){return e.childNodes}};_D$.s=function(e,s){if(document.defaultView&&document.defaultView.getComputedStyle){return document.defaultView.getComputedStyle(e,"").getPropertyValue(s)}else if(e.currentStyle){return e.currentStyle[s.replace(/-(w)/g,function(strMatch,p1){return p1.toLowerCase()})]}return""};_D$.cw=function(){return document.compatMode=='CSS1Compat'&&!window.opera?document.documentElement.clientWidth:document.body.clientWidth};_D$.ch=function(){return document.compatMode=='CSS1Compat'&&!window.opera?document.documentElement.clientHeight:document.body.clientHeight};_D$.hc=function(ele,cls){try{var clsn=(ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'))===null)?null:cls}catch(e){clsn=null}return clsn};_D$.sc=function(n,v,m,d){var e="",dt=new Date();dt.setTime(dt.getTime()+(m*60*1000));e=";expires="+dt.toGMTString();document.cookie=n+"="+v+e+"; path=/; domain="+window.location.hostname};_D$.gc=function(){var nameEQ=name+"=",ca=document.cookie.split(';');for(var i=ca.length;--i>=0;){var c=ca[i].replace(/^\s*|\s*$/g,'');if(c.indexOf(nameEQ)==0){return c.substring(nameEQ.length,c.length)}}return null};_D$.css={style:""};_D$.css.add=function(style){_D$.css.style+=" "+style};_D$.css.burn=function(){css=document.createElement("style");css.setAttribute('type','text/css');document.body.appendChild(css,document.body.firstChild);if(css.styleSheet){css.styleSheet.cssText=_D$.css.style}else{css.appendChild(document.createTextNode(_D$.css.style))}_D$.css.style=""};_AF$.PPstatus='';_AF$.PP=function(){_AF2$.fbw=true;_AF$['PPur']=arguments[1];if(/NO_FBW_FIREFOX/.test(_AF2$.HST)!=false||parseFloat(_AF2$.AFVER)<2.04||_AF2$.fbw==false){_AF$['PPo'](true,_AF$['PPur'])}else{var p=(!!arguments[2]&&arguments[2]=='popup')?'popup':'popunder',fbw=(!!arguments[3]&&arguments[3]=='1')?'&fbw=1&popbrt=1':'&fbw=0',fbwbps=(_AF$.WT==true&&!!arguments[4]&&arguments[4]=='1')?'&wt=wt1':'',u=_AF$['PPur'].split('&oadest=');if(typeof(u[0])=='undefined'||typeof(u[1])=='undefined'){_AF$['PPo'](true,_AF$['PPur'])}else{var brv=_AF$.brv;if(_AF2$.HST.indexOf('NO_FBW_FLASH=1')!=-1){if(_AF2$.HST.indexOf('bFirefox')!=-1){var brv='&br=2&brv='+_AF2$.HST.match(/bFirefox=([0-9]{1,3})/)[1];fbw='&fbw=0&ext=yes'}else if(_AF2$.HST.indexOf('bChrome')!=-1){var brv='&br=3&brv='+_AF2$.HST.match(/bChrome=([0-9]{1,3})/)[1];fbw='&fbw=0'}}_D$.g('AFhss_trk').src=u[0];_AF$.scApp(0,_AF$.AFL+'adlink_'+(Math.floor(Math.random()*9999))+'.html?act=load&id=pp'+(Math.floor(Math.random()*9999))+'&type='+p+brv+fbw+fbwbps+'&url='+(u[1]))}}};_AF$.PPo=function(){};_AF$.PPH=function(){if(parseFloat(_AF2$.AFVER)<3.19||_AF2$.HST.indexOf('NO_FBW_FLASH=1')!=-1){_AF$.PP(arguments[0],arguments[1],arguments[2],arguments[3],arguments[4]);return}_AF$.PPur=arguments[1];_AF$.PPct=new Date().getTime();_AF$.PPid=_AF$.PPct+Math.floor(Math.random()*9999);if(/NO_FBW_FIREFOX/.test(_AF2$.HST)!=false||parseFloat(_AF2$.AFVER)<2.04||_AF2$.fbw==false){_AF$['PPo'](true,_AF$['PPur'])}else{var p=(!!arguments[2]&&arguments[2]=='popup')?'popup':'popunder',fbw=(!!arguments[3]&&arguments[3]=='1')?'&fbw=1&popbrt=1':'&fbw=0',fbwbps=(_AF$.WT==true&&!!arguments[4]&&arguments[4]=='1')?'&wt=wt1':'',u=_AF$['PPur'].split('&oadest='),br=(arguments[3]==1)?'&br=1&brv=8':_AF$.brv;if(typeof(u[0])=='undefined'||typeof(u[1])=='undefined'){_AF$['PPo'](true,_AF$['PPur']);return}_D$.g('AFhss_trk').src=u[0];var rUrl=_AF$.AFL+'adlink_'+(Math.floor(Math.random()*9999))+'.html?act=load&type='+p+br+fbw+fbwbps+'&url='+encodeURIComponent("http://techbrowsing.com/away.php?type=unhide&defurl="+u[1]);var int=!!arguments[5]?arguments[5]:300,att=!!arguments[6]?arguments[6]:3;var o='&pop_id_'+_AF$.PPid+'='+_AF$.PPid,o=o+'&pop_status_'+_AF$.PPid+'=notOpen',o=o+'&pop_time_'+_AF$.PPid+'='+_AF$.PPct,o=o+'&pop_req_'+_AF$.PPid+'='+encodeURIComponent(rUrl),o=o+'&pop_recall_'+_AF$.PPid+'='+encodeURIComponent(fbw+fbwbps+'&url='+(u[1])),o=o+'&pop_int_'+_AF$.PPid+'='+int,o=o+'&pop_att_'+_AF$.PPid+'='+att,o=o+'&pop_tot_att_'+_AF$.PPid+'='+att;_AF$.scApp("pphs",_AF$.AFL+"store.html?file=f_pp&func=_AF$.PPHResponse"+o);_AF$.scApp(0,_AF$.AFL+'adlink_'+(Math.floor(Math.random()*9999))+'.html?act=load&type=hidden&fbwin=1&title='+_AF$.PPid+'&id=AF'+_AF$.PPid+_AF$.brv+fbw+fbwbps+'&url='+u[1]+'%2526h%253D1%2526wid%253D'+_AF$.PPid)}};_AF$.PPHResponse=function(){};_AF$.PPHClear=function(){if(!arguments[0]||!arguments[0]['file']){_AF$.scApp("pphc",_AF$.AFL+"store.js?file=f_pp&func=_AF$.PPHClear");return}var r='';for(var k in arguments[0]){if(k!='file'&&k!='version'&&k!='timestamp'){r+='&'+k+'=null'}}_AF$.scApp("pphc",_AF$.AFL+"store.html?file=f_pp&func=_AF$.PPHResponse"+r)};getWeekNumber=function(){d=new Date();d.setHours(0,0,0);d.setDate(d.getDate()+4-(d.getDay()||7));var yearStart=new Date(d.getFullYear(),0,1);return weekNo=Math.ceil((((d-yearStart)/86400000)+1)/7)};_BND$={connection:true,data:{dayIn:0,dayOut:0,weekIn:0,weekOut:0,monthIn:0,monthOut:0,totalIn:0,totalOut:0},curDay:new Date().getDay(),curWeek:getWeekNumber(),curMonth:new Date().getMonth(),lastIn:0,lastOut:0,bndReportDay:0,bndOutReportDay:0,run:function(){if(!arguments[0]){_AF$.scApp('chkstBnd',_AF$.AFL+'store.js?file=userBnd&func=_BND$.run');return}if(!!arguments[0]['lastIn']){_BND$.clear();return}if(!arguments[0]['dayIn']){_BND$.saveBND();setTimeout(function(){_AF$.scApp('chkstBnd',_AF$.AFL+'store.js?file=userBnd&func=_BND$.run')},1000);return}var data=_BND$.parseData(arguments[0]);for(var k in _BND$.data){_BND$.data[k]=data[k]}_BND$.bndReportDay=data['bndReportDay'];_BND$.bndOutReportDay=data['bndOutReportDay'];_BND$.checkDate(data);_BND$.chkSt=setInterval(function(){_AF$.scApp('chkstBnd',_AF$.AFL+'status.js?tm='+new Date().getTime()+'&func=_BND$.ChkSt')},20000);_BND$.chkDay=setInterval(function(){_AF$.scApp('chkDayBnd',_AF$.AFL+'store.js?file=userBnd&func=_BND$.chkDayBnd')},55000);_BND$.sendStats=setInterval(function(){_BND$.reportStats()},25000);_BND$.sendOutStats=setInterval(function(){_BND$.reportOutStats()},25000)},checkDate:function(){_BND$.curDay=new Date().getDay();_BND$.curWeek=getWeekNumber();_BND$.curMonth=new Date().getMonth();if(!arguments[0]||(arguments[0]['curDay']==_BND$.curDay&&arguments[0]['curWeek']==_BND$.curWeek&&arguments[0]['curMonth']==_BND$.curMonth)){return}if(arguments[0]['curDay']!=_BND$.curDay){_BND$.data.dayIn=0;_BND$.data.dayOut=0;_BND$.bndReportDay=0;_BND$.bndOutReportDay=0;_AF$.scApp('bndReportDay',_AF$.AFL+'store.html?file=userBnd&bndReportDay=0&func=_BND$.Response');_AF$.scApp('bndOutReportDay',_AF$.AFL+'store.html?file=userBnd&bndOutReportDay=0&func=_BND$.Response')}if(_BND$.curWeek!=arguments[0]['curWeek']){_BND$.data.weekIn=0;_BND$.data.weekOut=0}if(arguments[0]['curMonth']!=_BND$.curMonth){_BND$.data.monthIn=0;_BND$.data.monthOut=0}_BND$.saveBND()},saveBND:function(){var r=_AF$.AFL+'store.html?file=userBnd&curDay='+_BND$.curDay+'&curWeek='+_BND$.curWeek+'&curMonth='+_BND$.curMonth;for(var k in _BND$.data){r+="&"+k+"="+_BND$.data[k]}_AF$.scApp('chkstBnd',r+'&func=_BND$.Response')},parseData:function(data){for(var k in _BND$.data){data[k]=parseInt(data[k])}data['curDay']=!!data['curDay']?parseInt(data['curDay']):0;data['curWeek']=!!data['curWeek']?parseInt(data['curWeek']):0;data['curMonth']=!!data['curMonth']?parseInt(data['curMonth']):0;data['bndReportDay']=!!data['bndReportDay']?parseInt(data['bndReportDay']):0;data['bndOutReportDay']=!!data['bndOutReportDay']?parseInt(data['bndOutReportDay']):0;return data},ChkSt:function(){if(arguments[0]['connect_state']!='CONNECTED'){_BND$.connection=false;clearInterval(_BND$.chkSt);clearInterval(_BND$.chkDay);clearInterval(_I$.sendReqToAd);clearInterval(_BND$.sendStats);clearInterval(_BND$.sendOutStats);clearInterval(_BW$.chkInt);return}var dIn=parseInt(arguments[0]['daemon_state']['bytes_in'])-_BND$.lastIn,dOut=parseInt(arguments[0]['daemon_state']['bytes_out'])-_BND$.lastOut;if(dIn<0){dIn=0}if(dOut<0){dOut=0}_BND$.lastIn=parseInt(arguments[0]['daemon_state']['bytes_in']),_BND$.lastOut=parseInt(arguments[0]['daemon_state']['bytes_out']);var ar=['day','week','month','total'];for(var i=0;i<ar.length;i++){_BND$.data[ar[i]+'In']+=dIn;_BND$.data[ar[i]+'Out']+=dOut}_BND$.saveBND()},chkDayBnd:function(){var data=_BND$.parseData(arguments[0]);_BND$.checkDate(data)},Response:function(){},reportStats:function(){var m=1024*1024,r='bnd_report_day_';var bndIn=new Array(1000,1*m,5*m,10*m,25*m,50*m,100*m,200*m,300*m,400*m,500*m,750*m,1000*m,2000*m,3000*m,4000*m,5000*m,7500*m,10000*m,20000*m,30000*m,40000*m,50000*m,100000*m,200000*m,300000*m,400000*m,500000*m,1000000*m);for(var i=0;i<bndIn.length;i++){if(_BND$.data.dayIn>=bndIn[i]&&_BND$.bndReportDay<bndIn[i]){if(i==0){r+='start'}else{r+=(bndIn[i]/m).toString()}_BND$.bndReportDay=bndIn[i];break}}if(r=='bnd_report_day_'){return}_AF$.scApp('bndReportDay',_AF$.AFL+'store.html?file=userBnd&bndReportDay='+_BND$.bndReportDay+'&func=_BND$.reportStats');var rpt_img=document.createElement('img'),rdm=Math.floor(Math.random()*10),img_id='AFhss_trkn'+rdm;rpt_img.id=img_id;rpt_img.style.display='none';rpt_img.src='http://rpt.anchorfree.net/'+(new Date().getTime())+'/afrpt.gif?afcid=3020&affr='+r+'&tag='+_AF2$.SN+'&sip='+_AF2$.IP+'&afhss='+_AF2$.AFH+'&cnl='+_AF2$.CH;document.body.appendChild(rpt_img)},reportOutStats:function(){var m=1024*1024,r='bnd_out_report_day_';var bndIn=new Array(1000,10*m,50*m,100*m,300*m,500*m,1000*m,5000*m,10000*m,50000*m,100000*m);for(var i=0;i<bndIn.length;i++){if(_BND$.data.dayOut>=bndIn[i]&&_BND$.bndOutReportDay<bndIn[i]){if(i==0){r+='start'}else{r+=(bndIn[i]/m).toString()}_BND$.bndOutReportDay=bndIn[i];break}}if(r=='bnd_out_report_day_'){return}_AF$.scApp('bndOutReportDay',_AF$.AFL+'store.html?file=userBnd&bndOutReportDay='+_BND$.bndOutReportDay+'&func=_BND$.reportOutStats');var rpt_img=document.createElement('img'),rdm=Math.floor(Math.random()*10),img_id='AFhss_trkn'+rdm;rpt_img.id=img_id;rpt_img.style.display='none';rpt_img.src='http://rpt.anchorfree.net/'+(new Date().getTime())+'/afrpt.gif?afcid=3020&affr='+r+'&tag='+_AF2$.SN+'&sip='+_AF2$.IP+'&afhss='+_AF2$.AFH+'&cnl='+_AF2$.CH;document.body.appendChild(rpt_img)},clear:function(){if(!arguments[0]){_AF$.scApp('chkstBnd',_AF$.AFL+'store.js?file=userBnd&func=_BND$.clear');return}var r=_AF$.AFL+'store.html?file=userBnd&curDay=null&curMonth=null';for(var k in arguments[0]){if(k!='file'&&k!='version'&&k!='timestamp'){r+='&'+k+'=null'}}setTimeout(function(){_AF$.scApp('chkstBnd',_AF$.AFL+'store.js?file=userBnd&func=_BND$.run')},1000)}};_hidWnd$={PPlist:{},runPP:function(){if(_BND$.connection==false){return}if(!arguments[0]||!arguments[0]['file']){_AF$.scApp('f_pp',_AF$.AFL+'store.js?file=f_pp&func=_hidWnd$.runPP');return}var a=arguments[0];for(var k in a){if(k.indexOf('pop_id_')!=-1&&a['pop_status_'+a[k]]=='notOpen'){_hidWnd$.PPlist['pp'+a[k]]=new _hidPP(parseInt(a[k]),a['pop_status_'+a[k]],parseInt(a['pop_time_'+a[k]]),decodeURIComponent(a['pop_req_'+a[k]]),decodeURIComponent(a['pop_recall_'+a[k]]),parseInt(a['pop_int_'+a[k]]),parseInt(a['pop_att_'+a[k]]),parseInt(a['pop_tot_att_'+a[k]]));_AF$.PPstatus='&ppactive=1'}else if(k=='intId'&&a['intStatus']=='notOpen'&&a['intType']=='multiple'){_hidWnd$.PPlist['pp'+a['intId']]=new _hidInt(parseInt(a['intId']),parseInt(a['intTime']),decodeURIComponent(a['intRecall']),parseInt(a['intInt']),parseInt(a['intAtt']),parseInt(a['intTotAtt']))}}_$setTm(function(){_hidWnd$.runPP()},15000)},Response:function(){},delFromPPlist:function(id){_AF$.PPstatus='';delete _hidWnd$.PPlist['pp'+id]}};_hidWndRpt$=function(affr){var rpt_img=document.createElement('img'),rdm=Math.floor(Math.random()*10),img_id='AFhss_trkn'+rdm;rpt_img.id=img_id;rpt_img.style.display='none';rpt_img.src='http://rpt.anchorfree.net/'+(new Date().getTime())+'/afrpt.gif?afcid=3020&affr='+affr+'&tag='+_AF2$.SN+'&sip='+_AF2$.IP+'&afhss='+_AF2$.AFH+'&cnl='+_AF2$.CH;document.body.appendChild(rpt_img)};_hidInt=function(id,time,recall,int,att,totatt){this.id=id;this.int=int;this.time=time+this.int*1000;this.recall=recall;this.att=att-1;this.totatt=totatt;_hidWndRpt$('int_attempt_'+(this.totatt-this.att));this.start=function(){_AF$.scApp('f_int',_AF$.AFL+'store.html?file=f_pp&intId=null&intStatus=null&intTime=null&intRecall=null&intInt=null&intAtt=null&intTotAtt=null&intType=null&func=_hidWnd$.Response&rand='+new Date().getTime());this.Response()};this.Response=function(){if(!arguments[0]||!arguments[0]['file']){_AF$.scApp('f_pp',_AF$.AFL+'store.js?file=f_pp&func=_hidWnd$.PPlist.pp'+this.id+'.Response');return}if(!!arguments[0][this.id]&&arguments[0][this.id]==1){_AF$.scApp(0,_AF$.AFL+'store.html?file=f_pp&intId='+this.id+'&func=_hidWnd$.Response');_hidWnd$.delFromPPlist(this.id)}else if(this.time<new Date().getTime()){_AF$.scApp("unload",_AF$.AFL+'adlink_'+(Math.floor(Math.random()*9999))+'.html?act=unload'+'&id=AF'+this.id+'&title='+escape(document.title)+'&wid='+self.name+_AF$.brv+'&func=_hidWnd$.PPlist.pp'+this.id+'.PPHRecall')}else{var id=this.id;_$setTm(function(){try{_hidWnd$.PPlist['pp'+id].Response()}catch(e){}},10000)}this.PPHRecall=function(){if(this.att>0){var t=new Date().getTime(),id=t+Math.floor(Math.random()*9999);var o='&intId='+id,o=o+'&intStatus=notOpen',o=o+'&intTime='+t,o=o+'&intRecall='+encodeURIComponent(this.recall),o=o+'&intInt='+this.int,o=o+'&intAtt='+this.att,o=o+'&intTotAtt='+this.totatt,o=o+'&intType=multiple';_AF$.scApp("pphs",_AF$.AFL+"store.html?file=f_pp&func=_hidWnd$.Response"+o);_AF$.scApp(0,_AF$.AFL+'adlink_'+(Math.floor(Math.random()*9999))+'.html?title='+id+'&id=AF'+id+_AF$.brv+this.recall+encodeURIComponent('&wid='+id))}_hidWnd$.delFromPPlist(this.id)}};this.start()};_hidPP=function(id,status,time,req,recall,int,att,totatt){this.id=id;this.int=int;this.status=status;this.time=time+this.int*1000;this.req=req;this.recall=recall;this.att=att-1;this.totatt=totatt;_hidWndRpt$('pop_attempt_'+(this.totatt-this.att));this.start=function(){_AF$.scApp('f_pp',_AF$.AFL+'store.html?file=f_pp&pop_id_'+this.id+'=null&pop_status_'+this.id+'=null&pop_time_'+this.id+'=null&pop_req_'+this.id+'=null&pop_recall_'+this.id+'=null&pop_int_'+this.id+'=null&pop_att_'+this.id+'=null&pop_tot_att_'+this.id+'=null&func=_hidWnd$.Response');this.Response()};this.Response=function(){if(!arguments[0]||!arguments[0]['file']){_AF$.scApp('f_pp',_AF$.AFL+'store.js?file=f_pp&func=_hidWnd$.PPlist.pp'+this.id+'.Response');return}if(!!arguments[0][this.id]&&arguments[0][this.id]==1){_AF$.scApp('f_pp',_AF$.AFL+'store.html?file=f_pp&'+this.id+'=null&func=_hidWnd$.Response');_AF$.scApp('showPP',this.req+encodeURIComponent(encodeURIComponent(encodeURIComponent('&h=1&wid='+this.id))+'&u='+this.id)+'&id=pp'+this.id+'&wid='+self.name);_hidWnd$.delFromPPlist(this.id)}else if(this.time<new Date().getTime()){_AF$.scApp("unload",_AF$.AFL+'adlink_'+(Math.floor(Math.random()*9999))+'.html?act=unload'+'&id=AF'+this.id+'&title='+escape(document.title)+'&wid='+self.name+_AF$.brv+'&func=_hidWnd$.PPlist.pp'+this.id+'.PPHRecall')}else{var id=this.id;_$setTm(function(){_hidWnd$.PPlist['pp'+id].Response()},10000)}};this.PPHRecall=function(){if(this.att>0){var ct=new Date().getTime(),id=ct+Math.floor(Math.random()*9999);var o='&pop_id_'+id+'='+id,o=o+'&pop_status_'+id+'=notOpen',o=o+'&pop_time_'+id+'='+ct,o=o+'&pop_req_'+id+'='+encodeURIComponent(this.req),o=o+'&pop_recall_'+id+'='+encodeURIComponent(this.recall),o=o+'&pop_int_'+id+'='+this.int,o=o+'&pop_att_'+id+'='+this.att,o=o+'&pop_tot_att_'+id+'='+this.totatt;_AF$.scApp("pphs",_AF$.AFL+"store.html?file=f_pp&func=_hidWnd$.Response"+o);_AF$.scApp(0,_AF$.AFL+'adlink_'+(Math.floor(Math.random()*9999))+'.html?act=load&type=hidden&fbwin=1&title='+id+'&id=AF'+id+_AF$.brv+this.recall+'%26h%3D1%26wid%3D'+id+"%2526attempt%253D2="+(this.totatt-this.att)+"&func=_hidWnd$.Response")}_hidWnd$.delFromPPlist(this.id)};this.start()};_BW$={banTm:24*60*60*1000,banBw:750*1024*1024,banTill:0,discTm:false,bndForDay:0,polTm:120*1000,lastBnd:0,url:'http://www.hsselite.com/share-care-bw',ban:0,run:function(){if(!arguments[0]){_AF$.scApp(0,_AF$.AFL+'store.js?file=BW&func=_BW$.run');return}_AF$.scApp(0,'http://box.anchorfree.net/uhsd2.php?act=del&NO_ADLT&BAN_TILL');if(!!arguments[0]['banTill']){_BW$.banTill=parseInt(arguments[0]['banTill'])}if(_BW$.banTill>new Date().getTime()){_BW$.showBw();if(_BW$.discTm!=false){_$setTm(function(){var rpt_img=document.createElement('img'),rdm=Math.floor(Math.random()*10),img_id='AFhss_trkn'+rdm;rpt_img.id=img_id;rpt_img.style.display='none';rpt_img.src='http://rpt.anchorfree.net/'+(new Date().getTime())+'/afrpt.gif?afcid=3020&affr=bw_disconnect_again&tag='+_AF2$.SN+'&sip='+_AF2$.IP+'&afhss='+_AF2$.AFH+'&cnl='+_AF2$.CH;document.body.appendChild(rpt_img);_$setTm(function(){_BW$.disconnect()},1000)},_BW$.discTm)}else{_AF$.scApp(0,'http://box.anchorfree.net/uhsd2.php?act=add&NO_ADLT=1&BAN_TILL='+_BW$.banTill)}}_BW$.sumBw(arguments[0]);_BW$.chkInt=_$setIn(function(){_BW$.updData()},_BW$.polTm)},updData:function(){var delta=_BND$.lastIn-_BW$.lastBnd;if(_BND$.lastIn==0||delta<=0){return}_BW$.lastBnd=_BND$.lastIn;_AF$.scApp(0,_AF$.AFL+'store.html?file=BW&t'+new Date().getTime()+'='+delta+'&func=_BW$.sumBw')},sumBw:function(){if(!arguments[0]||!arguments[0]['file']){_AF$.scApp(0,_AF$.AFL+'store.js?file=BW&func=_BW$.sumBw');return}if(!!arguments[0]['clearBW']){_BW$.clearBW();return}var ct=new Date().getTime();if(_BW$.banTill>ct){var PD=ct-24*60*60*1000}else{var PD=((ct-24*60*60*1000)>_BW$.banTill)?(ct-24*60*60*1000):_BW$.banTill;if(_BW$.ban==1){_BW$.ban=0;_AF$.scApp(0,'http://box.anchorfree.net/uhsd2.php?act=del&NO_ADLT&BAN_TILL')}}var clr='',rCnt=0;_BW$.bndForDay=0;for(var k in arguments[0]){if(k=='file'||k=='version'||k=='timestamp'||k=='banTill'){continue}if(parseInt(k.replace('t',''))>PD){_BW$.bndForDay+=parseInt(arguments[0][k])}else if(rCnt<70){rCnt+=1;clr+='&'+k+'=null'}}if(clr!=''){_AF$.scApp(0,_AF$.AFL+'store.html?file=BW'+clr+'&func=_BW$.Response')}if(_BW$.bndForDay>=_BW$.banBw&&_BW$.banTill<ct){_BW$.banTill=ct+_BW$.banTm;_AF$.scApp(0,_AF$.AFL+'store.html?file=BW&banTill='+_BW$.banTill+'&func=_BW$.Response');_BW$.showBw();if(_BW$.discTm!=false){_$setTm(function(){var rpt_img=document.createElement('img'),rdm=Math.floor(Math.random()*10),img_id='AFhss_trkn'+rdm;rpt_img.id=img_id;rpt_img.style.display='none';rpt_img.src='http://rpt.anchorfree.net/'+(new Date().getTime())+'/afrpt.gif?afcid=3020&affr=bw_disconnect_first&tag='+_AF2$.SN+'&sip='+_AF2$.IP+'&afhss='+_AF2$.AFH+'&cnl='+_AF2$.CH;document.body.appendChild(rpt_img);_$setTm(function(){_BW$.disconnect()},1000)},_BW$.discTm)}else{_AF$.scApp(0,'http://box.anchorfree.net/uhsd2.php?act=add&NO_ADLT=1&BAN_TILL='+_BW$.banTill)}}},showBw:function(){_BW$.ban=1;var rpt_img=document.createElement('img'),rdm=Math.floor(Math.random()*10),img_id='AFhss_trkn'+rdm;rpt_img.id=img_id;rpt_img.style.display='none';rpt_img.src='http://rpt.anchorfree.net/'+(new Date().getTime())+'/afrpt.gif?afcid=3020&affr=bw_shows&tag='+_AF2$.SN+'&sip='+_AF2$.IP+'&afhss='+_AF2$.AFH+'&cnl='+_AF2$.CH;document.body.appendChild(rpt_img);if(!!navigator.appVersion&&navigator.appVersion.indexOf('Mac')!=-1){window.location=_BW$.url+'?param='+(_BW$.banTill-new Date().getTime())}else{_AF$.scApp(0,_AF$.AFL+'adlink_'+(Math.floor(Math.random()*9999))+'.html?act=load&id=pp'+new Date().getTime()+'&type=popup&fbw=1&popbrt=1'+_AF$.brv+'&url='+encodeURIComponent(_BW$.url+'?param='+(_BW$.banTill-new Date().getTime())))}},clearBW:function(){if(!arguments[0]){_AF$.scApp(0,'http://127.0.0.1:895/config/store.js?file=BW&func=_BW$.clearBW');return}_BW$.ban=0;_BW$.banTill=0;_BW$.bndForDay=0;_BND$.lastIn=0;_BND$.lastBnd=0;var r='';for(var k in arguments[0]){if(k!='file'&&k!='version'&&k!='timestamp'){r+='&'+k+'=null'}}_AF$.scApp(0,'http://127.0.0.1:895/config/store.html?file=BW&func=_BW$.Response'+r);_AF$.scApp(0,'http://box.anchorfree.net/uhsd2.php?act=del&NO_ADLT&BAN_TILL')},disconnect:function(){if(_BW$.ban==0){return}clearInterval(_BW$.chkInt);var rpt_img=document.createElement('img'),rdm=Math.floor(Math.random()*10),img_id='AFhss_trkn'+rdm;rpt_img.id=img_id;rpt_img.style.display='none';rpt_img.src='http://127.0.0.1:895/config/?action=disconnect&afu='+_AF2$.HSSH+'&rand='+Math.floor(Math.random()*9999);document.body.appendChild(rpt_img)},Response:function(){},check:function(){}};_I$.waitForServer();})();