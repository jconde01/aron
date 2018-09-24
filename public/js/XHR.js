//XHR.js   Biblioteca para accesar al objeto XMLHttpRequest
// 26/08/16 Raul Caceres Escalante rcaceres1966@gmail.com
// cel, 999 163 10 83
// uso:

// var peticion;
// peticion = obtenerXHR();

function obtenerXHR(){
	//Depende de la marca del 
	
	req = false;
		
	if(window.XMLHttpRequest){
	    req = new XMLHttpRequest(); //Para todos los navegadores excepto Explorer
	}else{
	   //Solo para Explorer/EDGE
	   if(ActiveXObject){
		   var vectorVersiones = ["MSXML2.XMLHttp.5.0","MSXML2.XMLHttp.4.0",
		                          "MSXML2.XMLHttp.3.0", "MSXML2.XMLHttp",
		                          "Microsoft.XMLHttp"];
		   //Probar una por una ave
		   for(var i=0; i<vectorVersiones.length; i++){
			   try{
				   req = new ActiveXObject(vectorVersiones[i]);
				   return req;
			   }catch(e){}			   
		   }
	   }
	}	
	return req; //Retorna el objeto XMLHttpRequest
}
