/** 
 *  
 */
E = {};
E.extend = function(sub, sup) {
	//借用构造函数  
	sub.prototype = new sup();
	//保留父类的构造函数,以便在子类构造函数中用调用，将父类变量绑定在this下  
	sub.prototype.superclass = sup;
	//因为重写了构造函数所以重新指定constructor,以使instanceof表现正常  
	sub.prototype.constructor = sub;
	//因为已经将变量绑定到子类上，所以删除原型上多余的变量  
	return sub;
};

//实现类是否实现了所有接口的方法  
E.implement = function() {
	var sub = arguments[0];
	for ( var i = 1; i < arguments.length; i++) {
		var sup = arguments[i];
		try {
			sup.implemented(sub);
		} catch (e) {
			throw new Error('no implements interface ' + sup);
		}
	}
};

E.factory = {};
//创建接口  
E.createInterface = E.factory.createInterface = function(methods) {
	var f = typeof arguments[0] === 'string';
	var p = f ? arguments : arguments[0];
	var len = p.length;
	var Interface = function() {
	};
	var _proto = Interface.prototype = {};
	_proto.implemented = function(constructor) {
		for ( var i = 0; i < len; i++) {
			var obj = new constructor();
			if (!obj[p[i]]) {
				throw new Error('no implements interface');
			}
		}
	};

	return new Interface();
};

/*****例子
 //Test接口  
 var Person = E.createInterface('say', 'eat');  
 var Chinese = function() {};  
 Chinese.prototype.say = function() {  
 alert('说汉语')  
 }  
 Chinese.prototype.eat = function() {  
 alert('吃中餐')  
 }  
 E.implement(Chinese, Person);

 //Test继承  
 var Instrument = function(name, tone) {  
 this.name = name;  
 this.tone = tone  
 }  
 Instrument.prototype.play = function() {  
 alert(this.name + '的音色：' + this.tone);  
 };  

 var Guitar = function(name, tone) {  
 this.superclass.call(this, name, tone);  
 }  
 Guitar = E.extend(Guitar, Instrument);  

 var fingerGuitar = new Guitar('杉田健司', '高音甜中音稳低音狠 ');  
 fingerGuitar.play();  
 alert(fingerGuitar instanceof Guitar);
 *******/
