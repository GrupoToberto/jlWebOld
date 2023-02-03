class JlView{
    #id;

    constructor(id){
        if (this.constructor == JlView)
			throw new Error("Abstract classes can't be instantiated.");

        this.#id=id;
    }

    getId(){
        return this.#id;
    }

    findViewById(id){
        var tag=document.getElementById(this.#id+id).tagName.toLowerCase();
        tag=tag[0].toUpperCase()+tag.substring(1);
        return eval('new Jl'+tag+'("'+this.#id+id+'");');
    }
}

class JlDiv extends JlView{
    constructor(id){
        super(id);
    }
}

class JlA extends JlTextTag{
    #href;

    constructor(id){
        super(id);
    }

    setH_Ref(href)
	{
		this.#href=href;
		var link=document.getElementById(super.getId());
		link.href=this.#href;
	}
}

class JlImg extends JlView{
    #path;

    constructor(id){
        super(id);
    }

    setPath(path)
	{
		this.#path=path;
		var pic=document.getElementById(super.getId());
		pic.setAttribute("src", this.#path);
	}
}

class JlTextTag extends JlView{
    #text;

    constructor(id){
        super(id);

        if (this.constructor == JlTextTag)
			throw new Error("Abstract classes can't be instantiated.");

        this.#text='';
    }

    setText(text){
        this.#text=text;

        var textTag=document.getElementById(super.getId());
		textTag.innerHTML=this.#text;
    }
}

class JlH5 extends JlTextTag{
    constructor(id){
        super(id);
    }
}

class JlP extends JlTextTag{
    constructor(id){
        super(id);
    }
}
