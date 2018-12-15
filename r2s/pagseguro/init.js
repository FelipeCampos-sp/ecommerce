//meios custom validator
$.validator.addMethod("validacpfcnpj", function(value, element) {
  return this.optional(element) || validarCpfCnpj(value);
}, "Digite CPF do titular valido");

$.validator.addMethod("validacartao", function(value, element) {
  return this.optional(element) || jcv_luhnCheck(value);
}, "Digite um cart\u00e3o valido");

function jcv_luhnCheck(cardNumber) {
        if (jcv_isLuhnNum(cardNumber)) {
            var no_digit = cardNumber.length;
            var oddoeven = no_digit & 1;
            var sum = 0;
            for (var count = 0; count < no_digit; count++) {
                var digit = parseInt(cardNumber.charAt(count));
                if (!((count & 1) ^ oddoeven)) {
                    digit *= 2;
                    if (digit > 9) digit -= 9;
                };
                sum += digit;
            };
            if (sum == 0) return false;
            if (sum % 10 == 0) return true;
        };
        return false;
}

function jcv_isLuhnNum(argvalue) {
        argvalue = argvalue.toString();
        if (argvalue.length == 0) {
            return false;
        }
        for (var n = 0; n < argvalue.length; n++) {
            if ((argvalue.substring(n, n+1) < "0") ||
                (argvalue.substring(n,n+1) > "9")) {
                return false;
            }
        }
        return true;
}

function isNumberKey(evt){
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
}

function validaCPF(s) {
	var c = s.substr(0,9);
	var dv = s.substr(9,2);
	var d1 = 0;
	for (var i=0; i<9; i++) {
		d1 += c.charAt(i)*(10-i);
 	}
	if (d1 == 0) return false;
	d1 = 11 - (d1 % 11);
	if (d1 > 9) d1 = 0;
	if (dv.charAt(0) != d1){
		return false;
	}
	d1 *= 2;
	for (var i = 0; i < 9; i++)	{
 		d1 += c.charAt(i)*(11-i);
	}
	d1 = 11 - (d1 % 11);
	if (d1 > 9) d1 = 0;
	if (dv.charAt(1) != d1){
		return false;
	}
    return true;
}
function validaCNPJ(CNPJ) {
	var a = new Array();
	var b = new Number;
	var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
	for (i=0; i<12; i++){
		a[i] = CNPJ.charAt(i);
		b += a[i] * c[i+1];
	}
	if ((x = b % 11) < 2) { a[12] = 0 } else { a[12] = 11-x }
	b = 0;
	for (y=0; y<13; y++) {
		b += (a[y] * c[y]);
	}
	if ((x = b % 11) < 2) { a[13] = 0; } else { a[13] = 11-x; }
	if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){
		return false;
	}
	return true;
}

function validarCpfCnpj(valor) {
	var s = (valor).replace(/\D/g,'');
	var tam=(s).length;
	if (!(tam==11 || tam==14)){
		return false;
	}
	if (tam==11 ){
		if (!validaCPF(s)){
			return false;
		}
		return true;
	}		
	if (tam==14){
		if(!validaCNPJ(s)){
			return false;			
		}
		return true;
	}
}

function up(lstr){ // converte minusculas em maiusculas
var str=lstr.value; //obtem o valor
lstr.value=str.toUpperCase(); //converte as strings e retorna ao campo
}

function down(lstr){ // converte maiusculas em minusculas
var str=lstr.value; //obtem o valor
lstr.value=str.toLowerCase(); //converte as strings e retorna ao campo
}

function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){
	if(v_fun=='telefone')
   	 v_obj.value=telefone(v_obj.value);
	if(v_fun=='cep')
   	 v_obj.value=cep(v_obj.value);
	if(v_fun=='site')
   	 v_obj.value=site(v_obj.value);
	if(v_fun=='data')
   	 v_obj.value=data(v_obj.value);
	if(v_fun=='data_mes_ano')
   	 v_obj.value=data_mes_ano(v_obj.value);
	if(v_fun=='dinheiro')
   	 v_obj.value=dinheiro(v_obj.value);
	if(v_fun=='sem_casas')
   	 v_obj.value=sem_casas(v_obj.value);
	if(v_fun=='casas_3')
   	 v_obj.value=casas_3(v_obj.value);
	if(v_fun=='soNumeros')
   	 v_obj.value=soNumeros(v_obj.value);
	if(v_fun=='palavra')
   	 v_obj.value=soPalavra(v_obj.value);
	if(v_fun=='palavraPonto')
   	 v_obj.value=soPalavraPonto(v_obj.value);
	if(v_fun=='cpf')
   	 v_obj.value=cpf(v_obj.value);
	if(v_fun=='cnpj')
   	 v_obj.value=cnpj(v_obj.value);
}

function leech(v){
    v=v.replace(/o/gi,"0")
    v=v.replace(/i/gi,"1")
    v=v.replace(/z/gi,"2")
    v=v.replace(/e/gi,"3")
    v=v.replace(/a/gi,"4")
    v=v.replace(/s/gi,"5")
    v=v.replace(/t/gi,"7")
    return v
}

function soNumeros(v){
    return v.replace(/\D/g,"")
}

function telefone(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
    v=v.replace(/^(\d\d)(\d)/g,"($1)$2")
    return v
}
function soPalavra(v){
	v=v.replace(/[^\w\.\+-:@]/g,"")
    v=v.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"")
    v=v.replace(/,/,"")
    v=v.replace(/ /,"")
    v=v.replace("+","")
    v=v.replace("-","")
    v=v.replace("www","")
    v=v.replace(".combr","")
	
    v=v.replace(/([\?&])=/,"$1")
	//testa se ja tem ponto
	total=0;
	palavra="";
	for (x=0;x<v.length;x++)
	{
		if(v.substr(x,1)==".")
			total++;
		if ((total<=1)||(v.substr(x,1)!="."))
		{
			if( ! (  ((x==0)&& (v.substr(x,1)==".")  )  ))//|| ((x==v.length-1)&&(v.substr(x,1)==".")) )
				palavra+=v.substr(x,1)+"";
			
		}
	}
	v=palavra;
	v=v.toLowerCase();
	return v
}
function soPalavraPonto(v){
	v=v.replace(/[^\w\.\+-:@]/g,"")
    v=v.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"")
    v=v.replace(/,/,"")
    v=v.replace(/ /,"")
    v=v.replace("+","")
    v=v.replace("-","")
	
    v=v.replace(/([\?&])=/,"$1")
	//testa se ja tem ponto
	total=0;
	palavra="";
	for (x=0;x<v.length;x++)
	{
		if(v.substr(x,1)==".")
			total++;
		if ((total<=4)||(v.substr(x,1)!="."))
		{
			if( ! (  ((x==0)&& (v.substr(x,1)==".")  )  ))//|| ((x==v.length-1)&&(v.substr(x,1)==".")) )
				palavra+=v.substr(x,1)+"";
			
		}
	}
	v=palavra;
	v=v.toLowerCase();
	return v
}
function cpf(v){
    v=v.substr(0,14);
	v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
    v=v.replace(/(\d{3})(\d)/,"$1.$2")
    v=v.replace(/(\d{3})(\d)/,"$1.$2")
    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
    return v
}

function cep(v){
	v=v.replace(/[^1234567890-]/g,"");
    v=v.replace(/^(\d{5})(\d)/,"$1-$2")
    return v
}

function cnpj(v){
   v=v.substr(0,18);
   v=v.replace(/\D/g,"")                           //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/,"$1.$2")
    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
    v=v.replace(/\.(\d{3})(\d)/,".$1/$2")
    v=v.replace(/(\d{4})(\d)/,"$1-$2")
    return v
}

function data_mes_ano(v){
    v=v.replace(/[^1234567890/]/g,"");
	v=v.replace(/^(\d{2})(\d)/,"$1/$2");
	v=v.substr(0,7);
    return v
}

function data(v){
    v=v.replace(/[^1234567890/]/g,"");
	v=v.replace(/^(\d{2})(\d)/,"$1/$2");
	v=v.replace(/^(\d{2})\/(\d{2})(\d)/,"$1/$2/$3");
	v=v.substr(0,10);
    return v
}

function dinheiro(v){
        v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
        v=v.replace(/^([0-9]{3}\.?){3}-[0-9]{2}$/,"$1.$2");
        v=v.replace(/(\d)(\d{2})$/,"$1.$2")
        return v
}

function sem_casas(v){
         v=v.replace(/[^1234567890]/g,"");
        return v
}

function casas_3(v){
        v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
        v=v.replace(/^([0-9]{3}\.?){3}-[0-9]{2}$/,"$1.$2");
        v=v.replace(/(\d)(\d{3})$/,"$1.$2")
        return v
}