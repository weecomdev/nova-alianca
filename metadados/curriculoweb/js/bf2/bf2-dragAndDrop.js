/*
 * Data de criação: 08/01/2008
 * 
 * Requer o bf2.js. (Esse script é importado automaticamente pelo bf2.Importer)
 */

bf2.DragAndDrop = {

	obj: null,

	configure: function(moveableBar, moveableContainer, minX, maxX, minY, maxY) {
		moveableBar.onmousedown	= bf2.DragAndDrop.startDrag;

		moveableBar.hmode = true;
		moveableBar.vmode = true;

		moveableBar.root = moveableContainer && moveableContainer != null ? moveableContainer : o ;

		if (moveableBar.hmode  && isNaN(parseInt(moveableBar.root.style.left  ))) moveableBar.root.style.left   = "0px";
		if (moveableBar.vmode  && isNaN(parseInt(moveableBar.root.style.top   ))) moveableBar.root.style.top    = "0px";
		if (!moveableBar.hmode && isNaN(parseInt(moveableBar.root.style.right ))) moveableBar.root.style.right  = "0px";
		if (!moveableBar.vmode && isNaN(parseInt(moveableBar.root.style.bottom))) moveableBar.root.style.bottom = "0px";

		moveableBar.minX	= typeof minX != 'undefined' ? minX : null;
		moveableBar.minY	= typeof minY != 'undefined' ? minY : null;
		moveableBar.maxX	= typeof maxX != 'undefined' ? maxX : null;
		moveableBar.maxY	= typeof maxY != 'undefined' ? maxY : null;
		
		moveableBar.xMapper = null;
		moveableBar.yMapper = null;

		moveableBar.root.onDragStart	= new Function();
		moveableBar.root.onDragEnd	= new Function();
		moveableBar.root.onDrag		= new Function();
	},

	startDrag: function(e) {
		var obj = bf2.DragAndDrop.obj = this;
		e = bf2.DragAndDrop.fixE(e);
		var y = parseInt(obj.vmode ? obj.root.style.top  : obj.root.style.bottom);
		var x = parseInt(obj.hmode ? obj.root.style.left : obj.root.style.right );
		obj.root.onDragStart(x, y);

		obj.lastMouseX	= e.clientX;
		obj.lastMouseY	= e.clientY;

		if (obj.hmode) {
			if (obj.minX != null)	obj.minMouseX	= e.clientX - x + obj.minX;
			if (obj.maxX != null)	obj.maxMouseX	= obj.minMouseX + obj.maxX - obj.minX;
		} else {
			if (obj.minX != null) obj.maxMouseX = -obj.minX + e.clientX + x;
			if (obj.maxX != null) obj.minMouseX = -obj.maxX + e.clientX + x;
		}

		if (obj.vmode) {
			if (obj.minY != null)	obj.minMouseY	= e.clientY - y + obj.minY;
			if (obj.maxY != null)	obj.maxMouseY	= obj.minMouseY + obj.maxY - obj.minY;
		} else {
			if (obj.minY != null) obj.maxMouseY = -obj.minY + e.clientY + y;
			if (obj.maxY != null) obj.minMouseY = -obj.maxY + e.clientY + y;
		}

		document.onmousemove	= bf2.DragAndDrop.drag;
		document.onmouseup	= bf2.DragAndDrop.end;

		return false;
	},

	drag: function(e) {
		e = bf2.DragAndDrop.fixE(e);
		var obj = bf2.DragAndDrop.obj;

		var ey	= e.clientY;
		var ex	= e.clientX;
		var y = parseInt(obj.vmode ? obj.root.style.top  : obj.root.style.bottom);
		var x = parseInt(obj.hmode ? obj.root.style.left : obj.root.style.right );
		var nx, ny;

		if (obj.minX != null) ex = obj.hmode ? Math.max(ex, obj.minMouseX) : Math.min(ex, obj.maxMouseX);
		if (obj.maxX != null) ex = obj.hmode ? Math.min(ex, obj.maxMouseX) : Math.max(ex, obj.minMouseX);
		if (obj.minY != null) ey = obj.vmode ? Math.max(ey, obj.minMouseY) : Math.min(ey, obj.maxMouseY);
		if (obj.maxY != null) ey = obj.vmode ? Math.min(ey, obj.maxMouseY) : Math.max(ey, obj.minMouseY);

		nx = x + ((ex - obj.lastMouseX) * (obj.hmode ? 1 : -1));
		ny = y + ((ey - obj.lastMouseY) * (obj.vmode ? 1 : -1));

		if (obj.xMapper)		nx = obj.xMapper(y)
		else if (obj.yMapper)	ny = obj.yMapper(x)

		bf2.DragAndDrop.obj.root.style[obj.hmode ? "left" : "right"] = nx + "px";
		bf2.DragAndDrop.obj.root.style[obj.vmode ? "top" : "bottom"] = ny + "px";
		bf2.DragAndDrop.obj.lastMouseX	= ex;
		bf2.DragAndDrop.obj.lastMouseY	= ey;

		bf2.DragAndDrop.obj.root.onDrag(nx, ny);
		return false;
	},

	end: function() {
		document.onmousemove = null;
		document.onmouseup   = null;
		bf2.DragAndDrop.obj.root.onDragEnd(	parseInt(bf2.DragAndDrop.obj.root.style[bf2.DragAndDrop.obj.hmode ? "left" : "right"]), 
									parseInt(bf2.DragAndDrop.obj.root.style[bf2.DragAndDrop.obj.vmode ? "top" : "bottom"]));
		bf2.DragAndDrop.obj = null;
	},

	fixE: function(e) {
		if (typeof e == 'undefined') e = window.event;
		if (typeof e.layerX == 'undefined') e.layerX = e.offsetX;
		if (typeof e.layerY == 'undefined') e.layerY = e.offsetY;
		return e;
	}
};