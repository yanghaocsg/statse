function addCookie(objName, objValue, objHours) {
    var str = objName + "=" + escape(objValue); 
    if (objHours > 0) {
        var date = new Date(); 
        var ms = objHours * 3600 * 1000; 
        date.setTime(date.getTime() + ms); 
        str += "; expires=" + date.toGMTString(); 
    } 
    document.cookie += str;
}

function getCookie(objName) {
    var arrStr = document.cookie.split("; "); 
    for(var i = 0;i < arrStr.length;i ++){ 
        var temp = arrStr[i].split("="); 
        if(temp[0] == objName)
            return unescape(temp[1]); 
    } 
    return "";
} 

function getPageCharset(){  
    var charSet = "";  
    var oType = getBrowser();  
    switch(oType){  
        case "IE":  
            charSet = document.charset;  
            break;  
        case "FIREFOX":  
            charSet = document.characterSet;  
            break;  
        case "CHROME":  
          charSet = document.characterSet;  
            break;  
        default:  
            break;  
    }  
    return charSet;  
}  
function getBrowser(){  
    var oType = "";  
    if(navigator.userAgent.indexOf("MSIE")!=-1){  
        oType="IE";  
    }else if(navigator.userAgent.indexOf("Firefox")!=-1){  
        oType="FIREFOX";
    }else if(navigator.userAgent.indexOf("WebKit")!=-1 ){  
      oType="CHROME";  
    }  
    return oType;  
}  

function requestLog() {
    var timestamp = Date.parse(new Date());
    var aj = $.ajax( {    
        url:'http://stat.se.xywy.com:8801/cc.js',
        data:{"refer":document.referrer, "title":document.title, "sw":screen.width, "sh":screen.height, "char":getPageCharset(), "t":timestamp, "c":document.cookie},
        type:'get',    
        dataType:'JSONP',    
        success:function(data) {},    
        error:function() {}  
    }); 
}

var cookie_old = getCookie('CSTAT');
if ("" == cookie_old) {
    var aj = $.ajax( {    
        url:'http://stat.se.xywy.com:8801/c.php',
        data:{},
        type:'get',    
        cache:false,    
        dataType:'jsonp',
        crossDomain: true,    
        success:function(data) {    
            if (0 == data.ret) {
                addCookie("CSTAT", data.data, 24);
                requestLog();
            }        
        },    
        error:function() {    
        }  
    }); 
}
else {
    requestLog();
}

