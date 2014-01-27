/*
 * http://digitalbush.com/tag/jquery/
 * Version: 1.1.2
 * Release: 2007-11-29
 */
/*
 a - Represents an alpha character (A-Z,a-z)
 9 - Represents a numeric character (0-9)
 * - Represents an alphanumeric character (A-Z,a-z,0-9) 
$("#date").mask("99/99/9999");
$("#phone").mask("(999) 999-9999");
$("#tin").mask("99-9999999");
$("#ssn").mask("999-99-9999");

$("#product").mask("99/99/9999",{placeholder:" "});   
$("#product").mask("99/99/9999",{completed:function(){alert("You typed the following: "+this.val());}});
$.mask.addPlaceholder('~',"[+-]");
$("#eyescript").mask("~9.99 ~9.99 999");
*/

eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(5($){$.11.w=5(b,d){2(3.t==0)6;2(1n b==\'1i\'){d=(1n d==\'1i\')?d:b;6 3.M(5(){2(3.12){3.S();3.12(b,d)}v 2(3.1v){4 a=3.1v();a.1W(P);a.1U(\'Q\',d);a.1h(\'Q\',b);a.1L()}})}v{2(3[0].12){b=3[0].1G;d=3[0].1E}v 2(K.V&&K.V.17){4 c=K.V.17();b=0-c.1Z().1h(\'Q\',-1Y);d=b+c.1X.t}6{7:b,Y:d}}};4 q={\'9\':"[0-9]",\'a\':"[A-T-z]",\'*\':"[A-T-1q-9]"};$.1p={1T:5(c,r){q[c]=r}};$.11.13=5(){6 3.1R("13")};$.11.1p=5(m,o){o=$.1K({H:"1F",U:B},o);4 n=C O("^"+$.1A(m.18(""),5(c,i){6 q[c]||((/[A-T-1q-9]/.15(c)?"":"\\\\")+c)}).14(\'\')+"$");6 3.M(5(){4 f=$(3);4 j=C 1w(m.t);4 h=C 1w(m.t);4 l=u;4 g=u;4 d=B;$.M(m.18(""),5(i,c){h[i]=(q[c]==B);j[i]=h[i]?c:o.H;2(!h[i]&&d==B)d=i});5 10(){y();x();1u(5(){$(f[0]).w(l?m.t:d)},0)};5 X(e){4 a=$(3).w();4 k=e.W;g=(k<16||(k>16&&k<N)||(k>N&&k<1s));2((a.7-a.Y)!=0&&(!g||k==8||k==1r)){E(a.7,a.Y)}2(k==8){R(a.7-->=0){2(!h[a.7]){j[a.7]=o.H;2($.D.1V){s=x();f.F(s.1m(0,a.7)+" "+s.1m(a.7));$(3).w(a.7+1)}v{x();$(3).w(1t.1k(d,a.7))}6 u}}}v 2(k==1r){E(a.7,a.7+1);x();$(3).w(1t.1k(d,a.7));6 u}v 2(k==1S){E(0,m.t);x();$(3).w(d);6 u}};5 Z(e){2(g){g=u;6(e.W==8)?u:B}e=e||1Q.1P;4 k=e.1O||e.W||e.1N;4 a=$(3).w();2(e.1M||e.1J){6 P}v 2((k>=1s&&k<=1I)||k==N||k>1H){4 p=L(a.7-1);2(p<m.t){2(C O(q[m.I(p)]).15(1d.1e(k))){j[p]=1d.1e(k);x();4 b=L(p);$(3).w(b);2(o.U&&b==m.t)o.U.1D(f)}}}6 u};5 E(b,a){1g(4 i=b;i<a&&i<m.t;i++){2(!h[i])j[i]=o.H}};5 x(){6 f.F(j.14(\'\')).F()};5 y(){4 a=f.F();4 b=0;1g(4 i=0;i<m.t;i++){2(!h[i]){R(b++<a.t){4 c=C O(q[m.I(i)]);2(a.I(b-1).1f(c)){j[i]=a.I(b-1);1C}}}}4 s=x();2(!s.1f(n)){f.F("");E(0,m.t);l=u}v l=P};5 L(a){R(++a<m.t){2(!h[a])6 a}6 m.t};f.1B("13",5(){f.G("S",10);f.G("1c",y);f.G("1b",X);f.G("1a",Z);2($.D.19)3.1l=B;v 2($.D.1j)3.1z(\'1o\',y,u)});f.J("S",10);f.J("1c",y);f.J("1b",X);f.J("1a",Z);2($.D.19)3.1l=5(){1u(y,0)};v 2($.D.1j)3.1y(\'1o\',y,u);y()})}})(1x);',62,124,'||if|this|var|function|return|begin||||||||||||||||||||||length|false|else|caret|writeBuffer|checkVal|||null|new|browser|clearBuffer|val|unbind|placeholder|charAt|bind|document|seekNext|each|32|RegExp|true|character|while|focus|Za|completed|selection|keyCode|keydownEvent|end|keypressEvent|focusEvent|fn|setSelectionRange|unmask|join|test||createRange|split|msie|keypress|keydown|blur|String|fromCharCode|match|for|moveStart|number|mozilla|max|onpaste|substring|typeof|input|mask|z0|46|41|Math|setTimeout|createTextRange|Array|jQuery|addEventListener|removeEventListener|map|one|break|call|selectionEnd|_|selectionStart|186|122|altKey|extend|select|ctrlKey|which|charCode|event|window|trigger|27|addPlaceholder|moveEnd|opera|collapse|text|100000|duplicate'.split('|'),0,{}))