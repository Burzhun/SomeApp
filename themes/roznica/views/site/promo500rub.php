<script type='text/javascript'>
  var dateFormat="dd.mm.yyyy",us_msg={
    missing:'Не задано обязательное поле: "%s"',invalid:'Недопустимое значение поля: "%s"',email_or_phone:"Не задан ни email, ни телефон",email_absent:"Не указан электронный адрес",phone_absent:"Не указан телефон",no_list_ids:"Не выбрано ни одного списка рассылки"}
      ,us_emailRegexp=/^[a-zA-Z0-9_+=-]+[a-zA-Z0-9\._+=-]*@[a-zA-Z0-9][a-zA-Z0-9-]*(\.[a-zA-Z0-9]([a-zA-Z0-9-]*))*\.([a-zA-Z]{
      2,6}
        )$/,us_phoneRegexp=/^\s*[\d +()-.]{
          7,32}
            \s*$/;
              if(typeof us_=="undefined")var us_=new function(){
                function i(a){
                  var b=a.getElementsByTagName("input");for(var c=0;c<b.length;c++){
                    var d=b[c];
                    if(d.getAttribute("name")=="charset"){
                      d.value==""&&(d.value=document.characterSet?document.characterSet:document.charset);
                      return}
                  }}
                function j(a){
                  var b=document,c=b.createElement("div");
                  c.style.position="absolute",c.style.width="auto",c=b.body.appendChild(c),c.appendChild(a),a.style.display="",d.push(c)}
                function k(){
                  var a=window,b=document,c=a.innerWidth?a.innerWidth:b.body.clientWidth,e=a.innerHeight?a.innerHeight:b.body.clientHeight;for(var f=0;f<d.length;f++){
                    var g=d[f],h=parseInt(g.offsetWidth+""),i=parseInt(g.offsetHeight+"");
                    g.style.left=(c-h)/2+b.body.scrollLeft+f*10,g.style.top=(e-i)/2+b.body.scrollTop+f*10}
                }var a=!1,b=window.onload;
                window.onload=function(){
                  us_.onLoad()}
                  ;var c=null,d=[],e=!1,f=!1,g={
                  },h=new Event("loadFormJavascript");
                window.addEventListener("loadFormJavascript",function(){
                  us_.onLoad()}
                                        ,!1),this.onLoad=function(){
                  var d,e=document.getElementsByTagName("form"),f=[];for(d=0;d<e.length;d++)f.push(e[d]);for(d=0;d<f.length;d++){
                    var g=f[d],h=g.getAttribute("us_mode");
                    if(!h)continue;
                    h=="popup"&&j(g),i(g)}
                  k(),c=window.onresize,window.onresize=function(){
                    us_.onResize()}
                    ,a=!0,b&&b();
                  var l=document.getElementsByClassName("formdatepicker");for(var d in l)var m=new Pikaday({
                    field:l[d],format:dateFormat.toUpperCase()}
                                                                                                          )}
                  ,this.onResize=function(){
                    k(),c&&c()}
                    ,trim=function(a){
                      return a==null?"":a.replace(/^\s\s*/,"").replace(/\s\s*$/,"")}
                      ,this.onSubmit=function(b){
                        return a?(_hideErrorMessages(b),!_validateTextInputs(b)||!_validateCheckboxes(b)||!_validateRadios(b)?!1:!0):(alert("us_.onLoad() has not been called"),!1)}
                        ,_validateTextInputs=function(a){
                          var b=a.querySelectorAll("input[type=text]");
                          if(b.length==0)return!0;for(var c=0;c<b.length;c++){
                            var d=b[c];
                            g[d.name]&&g[d.name].length>0?d.style["border-color"]=g[d.name]:g[d.name]=d.style["border-color"];
                            var h=d.getAttribute("name");
                            h==="email"&&(e=!0),h==="phone"&&(f=!0);
                            var i=trim(d.value),j=i==="",k=d.getAttribute("_required")==="1";
                            if(j){
                              if(k){
                                var l=us_msg.missing.replace("%s",d.getAttribute("_label"));
                                return _showErrorMessage(l,d),d.style["border-color"]="#ff592d",d.focus(),!1}
                            }else{
                              function m(a){
                                var b=us_msg.invalid.replace("%s",a.getAttribute("_label"));
                                _showErrorMessage(b,a),a.style["border-color"]="#ff592d",a.focus()}
                              var n=d.getAttribute("_validator"),o=null;
                              switch(n){
                                case null:case"":case"string":case"number":case"text":break;
                                case"date":o=dateFormat.replace(/dd?/i,"([0-9]{1,2})"),o=o.replace(/mm?/i,"([0-9]{1,2})"),o=o.replace(/yy{
                                                                                                                                      1,3}
                                                                                                                                      /i,"([0-9]{2,4})"),o=new RegExp(o);
                                                                                                                                      var p=o.exec(i);
                                  if(!(p&&p[1]&&p[2]&&p[3]))return m(d),!1;
                                  var q=parseInt(p[1],10),r=parseInt(p[2],10),s=parseInt(p[3],10),t=new Date(s,r-1,q);
                                  if(t.getFullYear()!=s||t.getMonth()+1!=r||t.getDate()!=q)return m(d),!1;
                                  break;
                                case"email":o=us_emailRegexp;
                                  break;
                                case"phone":o=us_phoneRegexp;
                                  break;
                                case"float":o=/^[+\-]?\d+(\.\d+)?$/;
                                  break;
                                default:return alert('Internal error: unknown validator "'+n+'"'),d.focus(),!1}
                              if(o&&!o.test(i)&&n!="date")return m(d),!1}
                          }return!0}
                          ,_validateCheckboxes=function(a){
                            return _validateOptionsList(a,"checkbox")}
                            ,_validateRadios=function(a){
                              return _validateOptionsList(a,"radio")}
                              ,_validateOptionsList=function(a,b){
                                function f(a){
                                  return!a||a==document?null:a.parentNode.nodeName&&a.parentNode.nodeName.toLowerCase()==="ul"?a.parentNode:f(a.parentNode)}
                                var c=a.querySelectorAll("input[type="+b+"]");
                                if(c.length==0)return!0;
                                var d=new Array,e="";for(var g=0;g<c.length;g++)c[g].getAttribute("_required")==="1"&&(e=c[g].getAttribute("name").replace(/(:|\.|\[|\])/g,"\\$1"),d.indexOf(e)===-1&&d.push(e));for(var h in d){
                                  var e=d[h],i=a.querySelectorAll("input[name="+e+"]:checked").length,j=a.querySelectorAll("input[name="+e+"]");
                                  if(i===0){
                                    var k=f(j[0]),l=us_msg.missing.replace("%s",j[0].getAttribute("_label"));
                                    return _showErrorMessage(l,k),!1}
                                }return!0}
                                ,_showErrorMessage=function(a,b){
                                  if(b){
                                    var c=b.parentNode.querySelector(".error-block");
                                    c.innerHTML=a,c.style.display="block"}
                                },_hideErrorMessages=function(a){
                                  var b=a.querySelectorAll(".error-block");
                                  if(b.length==0)return;for(var c=0;c<b.length;c++){
                                    var d=b[c];
                                    d.innerHtml="",d.style.display="none"}
                                }}
</script>
<script type='text/javascript' src='http://cp.unisender.com/v5/template-editor-new/js/lib/moment/moment-with-langs.min.js'>
</script>
<script type='text/javascript' src='http://cp.unisender.com/v5/template-editor-new/js/lib/datepicker/pikaday.js'>
</script>
<link rel='stylesheet' media='all' href='http://cp.unisender.com/v5/template-editor-new/js/lib/datepicker/pikaday.css'>
<form method="POST" action="http://api.unisender.com/ru/subscribe?hash=5cxsf6g7ok5pg7aa38e4wpbzq49q79y4do97317e" name="subscribtion_form" onsubmit="return us_.onSubmit(this);" us_mode="embed">
  <div class="container desktop">


    <p class="promoHeaed">
      500 рублей в подарок на первую покупку
    </p>

    <img src="/themes/roznica/img/promo500.jpg" alt="">
  



<div class="promofon">
  
 

    <table cellpadding="0" cellspacing="0" align="center" style="width: 100%; box-sizing: border-box; float: left; background-color: inherit;">
      <tbody>
        <tr>
          <td>
            <table cellpadding="0" cellspacing="0" align="center" style="border-radius: 0px; border: none; margin: 0px auto; border-spacing: 0px; background-color: inherit;">
              <tbody>
                <tr>
                  <td style="padding: 25px;">
                    <table cellpadding="0" cellspacing="0" style="border-spacing: 0px;">
                      <tbody>
                        <tr>
                          <td>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <table cellpadding="0" cellspacing="0" style="border-spacing: 0px;">
                              <tbody>
                                <tr>
                                  <td style="vertical-align: top;">
                                    <table cellpadding="0" cellspacing="0" style="border-spacing: 0px;">
                                      <tbody>
                                        <tr  >
                                          <td width="400"  >
                                            <table cellpadding="0" cellspacing="0" border="0" style="table-layout: fixed; border-spacing: 0px;">
                                              <colgroup>
                                                <col width="400">
                                              </colgroup>
                                              <tbody>
                                                <tr  >
                                                  <td width="400"   style="line-height: 1.4; border: 0px; vertical-align: top; background-color: inherit;">
                                                    <table style="border-collapse: separate; color: rgb(34, 34, 34); font-family: Arial, Helvetica, sans-serif; font-size: 12px;   width: 400px; border-spacing: 0px;" cellpadding="0" cellspacing="0">
                                                      <tbody>
                                                        <tr>
                                                          <td style="word-break: break-word; word-wrap: break-word; text-overflow: ellipsis; overflow: hidden;">
                                                            
                                                          </td>
                                                        </tr>
                                                      </tbody>
                                                    </table>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <table cellpadding="0" cellspacing="0" style="border-spacing: 0px;">
                              <tbody>
                                <tr>
                                  <td style="vertical-align: top;">
                                    <table cellpadding="0" cellspacing="0" style="border-spacing: 0px;">
                                      <tbody>
                                        <tr  >
                                          <td width="400"  >
                                            <table cellpadding="0" cellspacing="0" border="0" style="table-layout: fixed; border-spacing: 0px;">
                                              <colgroup>
                                                <col width="400">
                                              </colgroup>
                                              <tbody>
                                                <tr  >
                                                  <td width="400"   style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: rgb(34, 34, 34); vertical-align: top;">
                                                    <div style=" ">
                                                      <div>
                                                      </div>
                                                      
                                                      <div>
                                                        
                                                        
                                                        
                                                        <div style="display: inline-block; width: 66%;">
                                                          
                                                          <input placeholder='введите свое имя' type="text"  name="f_4097914" _validator="string" _label="Ваше имя" _required="0">
                                                          
                                                          <div class="error-block" style="display:none;color:#ff592d;font:11px/18px Arial;">
                                                          </div>
                                                          
                                                        </div>
                                                        
                                                      </div>
                                                      
                                                    </div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <table cellpadding="0" cellspacing="0" style="border-spacing: 0px;">
                              <tbody>
                                <tr>
                                  <td style="vertical-align: top;">
                                    <table cellpadding="0" cellspacing="0" style="border-spacing: 0px;">
                                      <tbody>
                                        <tr  >
                                          <td width="400"  >
                                            <table cellpadding="0" cellspacing="0" border="0" style="table-layout: fixed; border-spacing: 0px;">
                                              <colgroup>
                                                <col width="400">
                                              </colgroup>
                                              <tbody>
                                                <tr  >
                                                  <td width="400"   style="font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: rgb(34, 34, 34); vertical-align: top;">
                                                    <div style=" ">
                                                      <div>
                                                      </div>
                                                      
                                                      <div>
                                                         
                                                        <div style="display: inline-block; width: 66%;">
                                                          <input placeholder='введите свой email' type="text" name="email" _validator="email" _required="1"  _label="E-mail">
                                                          <div class="error-block" style="display:none;color:#ff592d;font:11px/18px Arial;">
                                                          </div>
                                                        </div>
                                                      </div>
                                                      
                                                    </div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <table cellpadding="0" cellspacing="0" style="border-spacing: 0px;">
                              <tbody>
                                <tr>
                                  <td style="vertical-align: top;">
                                    <table cellpadding="0" cellspacing="0" style="border-spacing: 0px;">
                                      <tbody>
                                        <tr  >
                                          <td width="400"  >
                                            <table cellpadding="0" cellspacing="0" border="0" style="table-layout: fixed; border-spacing: 0px;">
                                              <colgroup>
                                                <col width="400">
                                              </colgroup>
                                              <tbody>
                                                <tr  >
                                                  <td width="400"  >
                                                    
                                                    <table border="0" cellspacing="0" cellpadding="0" style="height: 100%; width: 100%; table-layout: fixed; border-spacing: 0px;">
                                                      
                                                      <tbody>
                                                        <tr>
                                                          
                                                          <td style="width: 100%; text-align: center;" align="center">
                                                            
                                                            <table border="0" cellspacing="0" cellpadding="0" style="height: 100%; width: 100%; table-layout: fixed; border-spacing: 0px;">
                                                              
                                                              <tbody>
                                                                <tr>
                                                                  
                                                                  <td style="width: 100%; text-align: center;" align="center">
                                                                    
                                                                    <table border="0" cellspacing="0" cellpadding="0" style="height: 100%; width: 100%; table-layout: fixed; border-spacing: 0px;">
                                                                      
                                                                      <tbody>
                                                                        <tr>
                                                                          
                                                                          <td style="width: 100%; text-align: center;" align="center">
                                                                            
                                                                            <table border="0" cellspacing="0" cellpadding="0" style="height: 100%; width: 100%; table-layout: fixed; border-spacing: 0px;">
                                                                              
                                                                              <tbody>
                                                                                <tr>
                                                                                  
                                                                                  <td style="width: 100%; text-align: center;" align="center">
                                                                                    
                                                                                    <table border="0" cellspacing="0" cellpadding="0" style="height: 100%; width: 100%; table-layout: fixed; border-spacing: 0px;">
                                                                                      
                                                                                      <tbody>
                                                                                        <tr>
                                                                                          
                                                                                          <td style="width: 100%; text-align: center;" align="center">
                                                                                            
                                                                                            <table border="0" cellspacing="0" cellpadding="0" style="height: 100%; width: 100%; table-layout: fixed; border-spacing: 0px;">
                                                                                              
                                                                                              <tbody>
                                                                                                <tr>
                                                                                                  
                                                                                                  <td style="width: 100%; text-align: center;" align="center">
                                                                                                    
                                                                                                    <table style="height: 100%; text-align: center; border-spacing: 0px;" border="0" cellspacing="0" cellpadding="0" align="center">
                                                                                                      <tbody>
                                                                                                        <tr>
                                                                                                          <td style="vertical-align:middle;">
                                                                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing: 0px;">
                                                                                                              <tbody>
                                                                                                                <tr>
                                                                                                                  <td align="center" valign="middle" >
                                                                                                                    <button href="javascript:;" target="_blank" style="width: 100%; display: inline-block; text-decoration: none; border: 0px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #252161; box-sizing: border-box; background-color: #bbbbbb;">
                                                                                                                      Получить подарок
                                                                                                                    </button>
                                                                                                                  </td>
                                                                                                                </tr>
                                                                                                              </tbody>
                                                                                                            </table>
                                                                                                          </td>
                                                                                                        </tr>
                                                                                                      </tbody>
                                                                                                    </table>
                                                                                                    
                                                                                                  </td>
                                                                                                  
                                                                                                </tr>
                                                                                                
                                                                                              </tbody>
                                                                                            </table>
                                                                                            
                                                                                          </td>
                                                                                          
                                                                                        </tr>
                                                                                        
                                                                                      </tbody>
                                                                                    </table>
                                                                                    
                                                                                  </td>
                                                                                  
                                                                                </tr>
                                                                                
                                                                              </tbody>
                                                                            </table>
                                                                            
                                                                          </td>
                                                                          
                                                                        </tr>
                                                                        
                                                                      </tbody>
                                                                    </table>
                                                                    
                                                                  </td>
                                                                  
                                                                </tr>
                                                                
                                                              </tbody>
                                                            </table>
                                                            
                                                          </td>
                                                          
                                                        </tr>
                                                        
                                                      </tbody>
                                                    </table>
                                                    
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
    </div>

    <br>
    <br>
    <br>
     
<div class="promoText">
	<p>Как получить скидку 500 рублей на покупку в kubachinka.ru</p>
	Подпишитесь на рассылку и получите в письме "Подписка подтверждена" купон на скидку 500 рублей. Скопируйте купон из письма, примените в поле "Введите купон" и получите скидку. Минимальная сумма украшения - от 17 000 рублей. 


</div>
  </div>
  <input type="hidden" name="charset" value="">
  <input type="hidden" name="default_list_id" value="4703302">
  <input type="hidden" name="overwrite" value="2">
</form>




<style>
	.container.desktop tr,.container.desktop td{
		padding: 0 !important;
	}

	.promoText{
		font-size: 16px;
		color: #252161;
		text-align: center; 
    line-height: 150%;
  }

  .promoText p{
    font-size: 24px;
    color: #252161; 
    margin-bottom: 20px;  
	}

    .container.desktop {
      padding: 15px;
      border: 1px solid #f2f1f3;
      margin-top: 15px;
       position: relative;
    }

    .promoHeaed{
      font-size: 23px;
      color: #252161;
      text-transform: uppercase;
      text-align: center;

    }

    .promofon{
      position: absolute;
      top: 290px;
right: 25px;
    }

    .promofon input[type='text']{
      background: #fff;
      margin-bottom: 10px;
      padding:10px 15px;
      width: 200px;
    }
      .promofon button{
        margin-left: 30px; 
  
      }
      .promofon button:hover{
        opacity: 0.9;
      }
  td{
    background: none !important;
    padding: 0 !important; 
    border: 0 !important;
  }
  table{
    border: 0!important;
  }

  .desktop>img{
    width: 100%;

  }

</style>