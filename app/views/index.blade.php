@extends('master')

@section('headExt')
<link href="assets/css/index.css" rel="stylesheet">
@if(Auth::check())
<link href="assets/css/editor.css" rel="stylesheet">
<link href="assets/css/plugin/spinkit.css" rel="stylesheet">
<script src="assets/js/plugin/mousetrap.min.js"></script>
<script src="assets/js/plugin/markdown.js"></script>
@endif
@stop

@section('footExt')

@if(Auth::check())
<script>
isSideBarFolded = false;
Mousetrap.bind(['command+b', 'ctrl+b'], function(e) {
	if(isSideBarFolded){
	expandSideBar();
		return false;
	}
	foldSideBar();
    return false;
});
$("#side-bar").click(function(){
	expandSideBar();
});
function foldSideBar(){
	if(!isSideBarFolded){
		$("#side-bar").addClass("side-bar-folded");
		$("#canvas").addClass("canvas-expanded");
		isSideBarFolded = true;
		if(activeView.expand){
			activeView.expand();
		}
	}
	resize();
}
function expandSideBar(){
	if(isSideBarFolded){
		$("#side-bar").removeClass("side-bar-folded");
		$("#canvas").removeClass("canvas-expanded");
		isSideBarFolded = false;
		if(activeView.fold){
			activeView.fold();
		}
	}
	resize();
}
</script>
<script>
sideBar = $("#side-bar");
canvas = $("#canvas");
welcomeView = $("#welcome-view");
editorView = $("#editor-view");
readerView = $("#reader-view");
btnMakePost = $("#btn-make-post");
modalMakePost = $("#modal-make-post");

welcomeView.activate = function(){
	selectedPostId = null;
	$(".post-active").removeClass("post-active");
}

btnMakePost.click(function(e){
	modalMakePost.modal();
});

iptNewPostTitle = $("#ipt-new-post-title");
btnModalMakeConfirm = $("#btn-modal-make-confirm");

btnModalMakeConfirm.click(function(){
	if(iptNewPostTitle.val()!==""){
		var url = "{{route('apis.posts.make')}}";
		$.ajax({
			url:url,
			type:"POST",
			data:{
				title:iptNewPostTitle.val()
			},
			success:function(res){
				console.log(res.data);
				var post = res.data.post;
				editorTitle.html(post.title);
				previewTitle.html(post.title);
				editorView.attr("data-post-title", post.title);
				editorView.attr("data-post-id", post.id);
				selectedPostId = post.id;
				activateView(editorView);
				addPostToMyNotesList(post);
				modalMakePost.modal('hide');
				foldSideBar();
			}
		});
	}else{
		console.log('need to write the post title')
	}
});
$(".view").hide();
activeView = null;
function activateView(view){
	if(activeView) activeView.fadeOut();
	view.fadeIn();
	if(view.activate){
		view.activate();
	}
	activeView = view;
}
activateView(welcomeView);

listMyNotes = $("#list-my-notes");

function addPostToMyNotesList(post){
	var item = $("<li></li>").html(post.title).attr("data-post-id", post.id);
	item.prependTo(listMyNotes).click(clickPostItem);
	$("#empty-item").remove();
}
function deletePostFromMyNotesList(post){
	var id = post.id;
	listMyNotes.children("li[data-post-id="+id+"]").remove();
}
canvasWidth = $(window).width()-235;
function resize(){
	var height = $(window).height();
	var width = $(window).width();
	sideBar.css('height', height-45);
	canvas.css('height', height-45);
	if(isSideBarFolded){
		canvas.css('width', width-30).trigger("transitionstart");
		canvasWidth = $(window).width()-30;
	}else{
		canvas.css('width', width-235).trigger("transitionstart");
		canvasWidth = $(window).width()-235;
	}
	if(activeView.refreshSize){
		activeView.refreshSize();
	}
}
onresize = resize;
resize();

function clickPostItem(e){
	console.log('postItem clicked');
	var id = $(e.target).attr("data-post-id");
	var title = $(e.target).attr("data-post-title");
	var post = {
		id:id,
		title:title
	}
	selectPostItem(post);
}
$("#side-bar li").click(clickPostItem);

selectedPostId = null;

function selectPostItem(post){
	if(selectedPostId === post.id){
		return true;
	}
	selectedPostId = post.id;
	$("#side-bar li.post-active").removeClass("post-active");
	$("#side-bar li[data-post-id="+post.id+"]").addClass("post-active");
	activateView(readerView);
}
readerTitle = $("#reader-title");
readerBody = $("#reader-body");
readerView.activate = function(){
	readerCanvas.objs = [];
	if(isSideBarFolded){
		readerView.expand();
	}else{
		readerView.fold();
	}
	$("#side-bar li").addClass("noRes");
	readerView.startLoading();
	var url = "{{route('apis.posts.show')}}";
	url = url.replace("%7Bpost_id%7D", selectedPostId);
	$.ajax({
		url:url,
		type:"GET",
		success:function(res){
			readerTitle.html(res.data.post.title);
			var body = res.data.post.body;
			body = strReplacer(body);
			readerBody.html(body);
			if(!res.data.post.drawings ==""){
				readerCanvas.objs = JSON.parse(res.data.post.drawings);
			}
			readerView.refreshSize();
			readerView.endLoading();

			$("#side-bar li").removeClass("noRes");
		}
	});
}

reader = $("#reader");
readerTool = $("#reader-tool");
readerBtnGroup = $("#reader-btn-group");
readerView.fold = function(){
	readerTool.fadeOut();
	readerBtnGroup.fadeOut();
}
readerView.expand = function(){
	readerTool.fadeIn();
	readerBtnGroup.fadeIn();
}
readerLoading = $("#reader-loading");
readerView.startLoading = function(){
	reader.fadeOut();
	readerLoading.fadeIn();
}
readerView.endLoading = function(){
	reader.fadeIn();
	readerLoading.fadeOut();
}
readerView.refreshSize = function(){
	var height = $(window).height();
	if(readerView.height() < height-45){
		readerView.css("height", height-45);
	}
	// readerCanvas.fadeOut(50);
	var width = $(window).width();
	if(isSideBarFolded){
		width = width-30;
	}else{
		width = width-235;
	}
	readerCanvas.canvas.css("width", width);
	readerCanvas.canvas.attr("width", width);

	if(reader.height()+40 > readerView.height()){
		height = reader.height()+40;
	}else{
		height = readerView.height();
	}
	readerCanvas.canvas.css("height", height);
	readerCanvas.canvas.attr("height", height);
	// canvas.on("transitionend", function(){
	// });
	redraw();
}
canvas.on("transitionstart", function(){
	readerCanvas.hide();
}).on("transitionend", function(){
	readerCanvas.fadeIn();
});
function strReplacer(str){
	str = markdown.toHTML(str);
	return str;
}
canvas.click(function(){
	if(!canvas.hasClass("canvas-expanded")){
		foldSideBar();
	}
});
readerView.isEditing = false;
readerCanvas = $("#reader-canvas");
readerCanvas.canvas = $("#reader-canvas canvas");
readerCanvas.addClass("noRes");
readerCanvas.currentObj = null;
readerCanvas.objs = [];
readerCanvas.mousePoint = null;
readerCanvas.color = "#E80377";
lineTool = $("#line-tool");
lineTool.click(function(){
	console.log("ready to make a line")
	readerCanvas.removeClass("noRes");
	readerView.isEditing = true;
	readerCanvas.currentObj = {
		type:"line",
		color:readerCanvas.color
	};
	readerCanvas.off('click');
	readerCanvas.one('click', function(e){
		var width = canvas.width();
		var x = e.clientX-30-width/2;
		var y = e.clientY+canvas.scrollTop()-45;
		readerCanvas.currentObj.p1 = {x:x,y:y};
		readerCanvas.one('click',function(e){
			var width = canvas.width();
			var x = e.clientX-30-width/2;
			var y = e.clientY+canvas.scrollTop()-45;
			readerCanvas.currentObj.p2 = {x:x,y:y};
			saveDrawings();
			readerView.isEditing = false;
			readerCanvas.addClass("noRes");
			readerCanvas.fadeOut(50,function(){
				redraw();
				readerCanvas.fadeIn();
			});

		});
	});
});
textTool = $("#text-tool");
readerCanvasTextInput = $("#reader-canvas-text-input");
iptCanvasText = $("#ipt-canvas-text");
textTool.click(function(){
	console.log("ready to make a text");
	readerCanvas.removeClass("noRes");
	readerView.isEditing = true;
	readerCanvas.currentObj = {
		type:"text",
		color:readerCanvas.color
	};
	readerCanvas.off('click');
	readerCanvas.one('click', function(e){
		var width = canvas.width();
		var x = e.clientX-30-width/2;
		var y = e.clientY+canvas.scrollTop()-45;
		readerCanvas.currentObj.p = {x:x,y:y};
		readerCanvasTextInput.css("left", e.clientX).css("top", e.clientY-100)
			.fadeIn();
		iptCanvasText.focus().on("keyup",function(e){
				switch(e.keyCode){
					case 13:
						iptCanvasText.val("");
						saveDrawings();
						readerView.isEditing = false;
						readerCanvasTextInput.fadeOut();
						readerCanvas.addClass("noRes");
						break;
					default:
						readerCanvas.currentObj.text = iptCanvasText.val();
				}
				redraw();
			});
	});
});
clearTool = $("#clear-tool");
clearTool.click(function(){
	clearDrawings();
	redraw();
});
colorTool = $("#color-tool");
modalColorPicker = $("#modal-color-picker");
colorsList = $("#colors-list");
colorsList.css("list-style","none");
colorsList.children("li").each(function(index, obj){
	$(obj).css("background-color", $(obj).attr("data-color"));
	$(obj).click(function(e){
		var color = $(e.target).attr("data-color");
		readerCanvas.color = color;
		modalColorPicker.modal('hide');
	});
});
colorTool.click(function(){
	modalColorPicker.modal();
});
function saveDrawings(){
	readerCanvas.objs.push(readerCanvas.currentObj);
	console.log(readerCanvas.objs);
	readerCanvas.currentObj = null;
	var url = "{{route('apis.posts.edit.drawings')}}";
	url = url.replace("%7Bpost_id%7D", selectedPostId);
	$.ajax({
		url:url,
		type:"PUT",
		data:{
			drawings:JSON.stringify(readerCanvas.objs)
		},
		success:function(res){
			console.log(res.message);
		}
	});
}
function clearDrawings(){
	readerCanvas.objs = [];
	var url = "{{route('apis.posts.edit.drawings')}}";
	url = url.replace("%7Bpost_id%7D", selectedPostId);
	$.ajax({
		url:url,
		type:"PUT",
		data:{
			drawings:JSON.stringify(readerCanvas.objs)
		},
		success:function(res){
			console.log(res.message);
		}
	});
}

readerCanvas.on('mousemove',function(e){
	var width = canvas.width();
	var x = e.clientX-30-width/2;
	var y = e.clientY+canvas.scrollTop()-45;
	readerCanvas.mousePoint = {x:x,y:y};
	$("#reader-status").html("x : "+x+", y : "+y);
	redraw();
});
// readerCanvas.drawings = [];
ctx = readerCanvas.canvas[0].getContext("2d");
function redraw(){
	clearAll();
	for(key in readerCanvas.objs){
		var obj = readerCanvas.objs[key];
		if(!obj){
			continue;
		}
		switch(obj.type){
			case "line":
				drawLine(obj.p1.x, obj.p1.y,obj.p2.x, obj.p2.y, obj.color);
				break;
			case "text":
				drawText(obj.p.x, obj.p.y, obj.text, obj.color);
				break;
		}
	}
	var obj = readerCanvas.currentObj;
	var mousePoint = readerCanvas.mousePoint;
	if(obj&&obj.p1&&mousePoint){
		switch(obj.type){
			case "line":
				drawLine(obj.p1.x, obj.p1.y,mousePoint.x,mousePoint.y,obj.color);
				break;
		}
	}
	if(obj&&obj.p&&obj.text){
		switch(obj.type){
			case "text":
				drawText(obj.p.x, obj.p.y, obj.text, obj.color);
				break;
		}
	}
}
function clearAll(){
	ctx.clearRect(0, 0,10000,10000);
}
function drawGuidePoint(x1,y1){
	var width = canvasWidth;
	if(isSideBarFolded){
		width = width-30;
	}else{
		width = width-235;
	}
	ctx.lineWidth=0.5;
	ctx.fillRect(x1 + width/2,y1,3,3);
}
function drawText(x,y,text,color){
	var width = canvasWidth;
	ctx.lineWidth=8;
	ctx.font = "30px Arial";
	ctx.strokeStyle = "#FFF";
	if(color){
		ctx.fillStyle = color;
	}else{
		ctx.fillStyle = "#E80377";
	}
	ctx.strokeText(text,x + width/2,y);
	ctx.fillText(text,x + width/2,y);
}
function drawLine(x1,y1,x2,y2,color){
	var width = canvasWidth;
	ctx.lineCap="round";
	ctx.strokeStyle = "#FFF";
	ctx.beginPath();
	ctx.lineWidth=8;
	ctx.moveTo(x1 + width/2,y1);
	ctx.lineTo(x2 + width/2,y2);
	ctx.stroke();
	ctx.beginPath();
	if(color){
		ctx.strokeStyle = color;
	}else{
		ctx.strokeStyle = "#E80377";
	}
	ctx.lineWidth=3;
	ctx.moveTo(x1 + width/2,y1);
	ctx.lineTo(x2 + width/2,y2);
	ctx.stroke();
}
redraw();

readerBtnEdit = $("#reader-btn-edit");

readerBtnEdit.click(function(){
	activateView(editorView);
});

readerBtnDelete = $("#reader-btn-delete");
modalDeletePost = $("#modal-delete-post");
btnModalDeleteConfirm = $("#btn-modal-delete-confirm");

readerBtnDelete.click(function(){
	modalDeletePost.modal();
});
btnModalDeleteConfirm.click(function(){
	var url = "{{route('apis.posts.destroy')}}";
	url = url.replace("%7Bpost_id%7D", selectedPostId);
	$.ajax({
		url:url,
		type:"DELETE",
		success:function(res){
			console.log(res);
			deletePostFromMyNotesList(res.data.post);
			selectedPostId = null;
			activateView(welcomeView);
			modalDeletePost.modal('hide');
		}
	});
});
editor = $("#editor");
preview = $("#preview");
previewTitle = $("#preview-title");
editorTitle = $("#editor-title");
previewBody = $("#preview-body");
editorBody = $("#editor-body");
editorView.activate = function(){
	$("#side-bar li").addClass("noRes");
	var url = "{{route('apis.posts.show')}}";
	url = url.replace("%7Bpost_id%7D", selectedPostId);
	$.ajax({
		url:url,
		type:"GET",
		success:function(res){
			previewTitle.html(res.data.post.title);
			editorTitle.html(res.data.post.title);
			var body = res.data.post.body;
			editorBody.val(body);
			body = strReplacer(body);
			previewBody.html(body);
			editorView.refreshSize();
			$("#side-bar li").removeClass("noRes");
		}
	});
}
editorView.refreshSize = function(){
	var height = $(window).height();
	editorView.css("height", height-45);
	editor.css("height", height-45);
	preview.css("height", height-45);
	editorBody.css("height", height-45-100);
	previewBody.css("height", height-145);
}
editorBody.on('keyup',function(){
	var body = editorBody.val();
	previewBody.html(strReplacer(body));
});

editorBtnSave = $("#editor-btn-save");

editorBtnSave.click(function(){
	var url = "{{route('apis.posts.edit.body')}}";
	url = url.replace("%7Bpost_id%7D", selectedPostId);
	$.ajax({
		url:url,
		type:"PUT",
		data:{
			body:editorBody.val()
		},
		success:function(res){
			console.log(res.message);
		}
	})
});

editorBtnDone = $("#editor-btn-done");

editorBtnDone.click(function(){
	var url = "{{route('apis.posts.edit.body')}}";
	url = url.replace("%7Bpost_id%7D", selectedPostId);
	$.ajax({
		url:url,
		type:"PUT",
		data:{
			body:editorBody.val()
		},
		success:function(res){
			console.log(res.message);
			activateView(readerView);
		}
	})
});
readerTitle.click(clickTitle);
editorTitle.click(clickTitle);
previewTitle.click(clickTitle);

modalEditTitle = $("#modal-edit-title");
iptPostTitle = $("#ipt-post-title");
btnModalEditTitleConfirm = $("#btn-modal-edit-title-confirm");
function clickTitle(e){
	var title = $(e.target).html();
	iptPostTitle.val(title);
	modalEditTitle.modal();
}
btnModalEditTitleConfirm.click(function(){
	var url = "{{route('apis.posts.edit.title')}}";
	url = url.replace("%7Bpost_id%7D", selectedPostId);
	$.ajax({
		url:url,
		type:"PUT",
		data:{
			title:iptPostTitle.val()
		},
		success:function(res){
			console.log(res.message);
			var title = res.data.post.title;
			editorTitle.html(title);
			previewTitle.html(title);
			readerTitle.html(title);
			$("#side-bar li[data-post-id="+res.data.post.id+"]").html(title);
			modalEditTitle.modal("hide");
		}
	})
});
brand = $("#brand");
brand.click(function(){
	activateView(welcomeView);
})

</script>
@endif
@stop

@section('body')
@if(Auth::check())
<div class="container-fluid">
	<div class="wrap">
		<div id="side-bar" class="side-bar">
			<div>
				<h1>Side Bar <small>⌘+b</small></h1>
				<h2>My notes</h2>
				<ul id="list-my-notes">
				@if(Auth::user()->posts->isEmpty())
					<li id="empty-item">
						Empty...
					</li>
				@else
					@foreach(Auth::user()->posts as $post)
					<li data-post-id="{{$post->id}}" data-post-title="{{$post->title}}">
						{{$post->title}}
					</li>
					@endforeach
				@endif
				</ul>
			</div>
		</div>
		<div id="canvas" class="canvas">
			<div id="welcome-view" class="view">
				<h1>Welcome you, {{Auth::user()->title}}</h1>
				<button class="btn btn-primary" id="btn-make-post">Make a new Note</button>
			</div>
			<div id="editor-view" class="view">
				<div id="editor" class="view-pane">
					<h2>
						<small>title : </small>
						<span id="editor-title"></span>
						<small> (editor)</small>
					</h2>
					<textarea id="editor-body"></textarea>
					<button id="editor-btn-save" class="btn btn-default">Just Save</button>
					<button id="editor-btn-done" class="btn btn-primary">Save and Done editing.</button>
				</div>
				<div id="preview" class="view-pane">
					<h2>
						<small>title : </small>
						<span id="preview-title"></span>
						<small> (preview)</small>
					</h2>
					<div id="preview-body">

					</div>
				</div>
			</div>
			<div id="reader-view" class="view">
				<div id="reader">
					<h2>
						<small>title : </small>
						<span id="reader-title"></span>
						<div id="reader-btn-group" class="btn-group pull-right">
							<button type="button" id="reader-btn-edit" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-edit"></span></button>
							<button type="button" id="reader-btn-delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
						</div>
					</h2>
					<div id="reader-body">

					</div>
				</div>
				<div id="reader-canvas">
					<canvas>
					</canvas>
				</div>
				<div id="reader-loading">
					<div class="spinner">
					  <div class="spinner-container container1">
					    <div class="circle1"></div>
					    <div class="circle2"></div>
					    <div class="circle3"></div>
					    <div class="circle4"></div>
					  </div>
					  <div class="spinner-container container2">
					    <div class="circle1"></div>
					    <div class="circle2"></div>
					    <div class="circle3"></div>
					    <div class="circle4"></div>
					  </div>
					  <div class="spinner-container container3">
					    <div class="circle1"></div>
					    <div class="circle2"></div>
					    <div class="circle3"></div>
					    <div class="circle4"></div>
					  </div>
					</div>
				</div>
				<div id="reader-tool">
					<h1>Tools</h1>
					<ul>
						<li id="line-tool">Line</li>
						<li id="text-tool">Text</li>
						<li id="clear-tool">Clear</li>
						<li id="color-tool">Color</li>
					</ul>
				</div>
				<div id="reader-status">
				</div>
				<div id="reader-canvas-text-input" style="display:none;">
					<input type="text" id="ipt-canvas-text" class="form-control">
				</div>
			</div>
		</div>
	</div>

</div>
</div>

<div class="modal fade" id="modal-make-post" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Make a new note</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<input type="text" class="form-control input-sm" id="ipt-new-post-title" placeholder="Enter the title for the new note">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-sm btn-primary" id="btn-modal-make-confirm">Create a new note</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal-delete-post" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Delete a note</h4>
			</div>
			<div class="modal-body">
				Are you sure to do that?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-sm btn-danger" id="btn-modal-delete-confirm">Delete this note</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal-edit-title" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit the title of this note</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<input type="text" class="form-control input-sm" id="ipt-post-title" placeholder="Enter the title for the new note">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-sm btn-primary" id="btn-modal-edit-title-confirm">Confirm</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal-color-picker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Select your favorite Color. :)</h4>
			</div>
			<div class="modal-body">
				<ul id="colors-list">
					<li data-color="#E80377"></li>
					<li data-color="#FF8609"></li>
					<li data-color="#73F500"></li>
					<li data-color="#00B2A9"></li>
					<li data-color="#0088FF"></li>
				</ul>
			</div>
			<div style="clear:both"></div>
		</div>
	</div>
</div>
@else

<div class="container">
	<div class="col-sm-6">
		<div class="jumbotron catch">
			<h1>KazTex</h1>
			<div class="catch-copy">Simple</div>
			<div class="catch-copy">Stylish</div>
			<div class="catch-copy">Swift</div>
			<h3>Note-taking App</h3>
				<h4>for students</h4>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="signin-form-container">
			<h2>Sign In</h2>
		{{Form::open(['route'=>'sessions.store'])}}
			<div class="form-group">
				{{Form::label('email', 'E-mail')}}
				{{Form::text('email', '',['class'=>'form-control', 'placeholder'=>'E-mail.'])}}
				@if($errors->first('email'))
					<br>
					<div class="alert alert-danger" role="alert">{{$errors->first('email')}}</div>
				@endif
			</div>
			<div class="form-group">
				{{Form::label('password', 'Password')}}
				{{Form::password('password', ['class'=>'form-control', 'placeholder'=>'Password.'])}}
				@if($errors->first('password'))
					<br>
					<div class="alert alert-danger" role="alert">{{$errors->first('password')}}</div>
				@endif
			</div>
			{{Form::submit('Sign in',['class'=>'btn btn-primary'])}}
			<a href="{{route('signup.create')}}" class="btn btn-default">Sign Up</a>
		{{Form::close()}}
		</div>
	</div>
</div>
@endif
@stop
