var notify = (function(){
	var selector = '#notify'; 
	var noty = $(selector);
	var type = 'alert-success';

	noty.find('.close').click(function(){
		noty.close();
	});
	noty.setType = function(t){
		this.removeClass(type);
		type = t;
		this.addClass(type);
	};
	noty.open = function(content, ttl){
		this.find('.content').html(content);
		this.removeClass('out');
		this.addClass('in');
		if(typeof ttl === 'number'){
			setTimeout(noty.close, ttl);
		}
	}
	noty.close = function(){
		noty.removeClass('in');
		noty.addClass('out');
	}
	return noty;
}());

var Pagger = function(){
	var selector = '#pagger';
	var page = $(selector);
	page.render = function(options){
		
	}

	return page;
}
var tableUsers = (function(){
	var selector = '#user-list';
	var pagger = Pagger(); 
	var dataUrl = 'http://localhost/enkulu_task/index.php/user/list/';
	var currentPage = 1; 
	var maxRow = 10;
	var nrow = 0;

	ajax = function(){
		$.ajax({
			url: dataUrl + currentPage,
			type: 'GET',
			contentType: "application/json;charset=utf-8",
			success: function(response){
				table.data(response.data);
			}
		});
	}

	var table = $(selector);
	table.add = function(user){
		var tr = this.find('#new-row');
		this.find('tbody').append(tr.clone());
		tr[0].id = user.id;
		var tds =tr.find('td');
		$(tds[0]).text(++nrow);
		$(tds[1]).text(user.name);
		$(tds[2]).text(user.email);
		$(tds[3]).text(user.phone);

		var avt = tr.find('img.avatar');
		if(user.avatar){
			console.log(user);
			avt.attr('src', 'public/uploads/avatar/'+user.avatar);
		}

		var editBtn = tr.find('.btn-edit');
		var deleteBtn = tr.find('.btn-delete');

		editBtn.click(function(){
			modalUser.updateUser(user);
		})

		deleteBtn.click(function(){
			modalConfrim.deleteUser(user);
		});
	}
	table.clear = function(){
		nrow = 0;
		this.find('tbody>tr:not(#new-row)').remove();
	}
	table.data = function(data){
		this.clear();
		data.forEach(function(user){
			table.add(user);
		})
	}
	table.get = function(){
		ajax();
	}
	table.page = function(page){
		currentPage = page;
		this.get();
	}
	table.next = function(){
		this.page(currentPage++);
	}
	table.prev = function(){
		this.page(currentPage--);
	}
	table.last = function(){
		
	}
	return table;
}());
var modalConfrim = (function(){
	var selector = '#confrim-modal';
	var deleteUrl = "http://localhost/enkulu_task/index.php/user/delete/";
	var modal = $(selector);
	var name = null;
	var id = null;

	function myDelete(){
		$.ajax({
			url: deleteUrl + id,
			type: 'DELETE',
			dataType: 'json',
			complete: function(){
				modal.close();
			},
			success: function(response){
				var notiStr = '<strong>success</strong> '+ response.message;
	        	notify.setType('alert-success');
	        	notify.open(notiStr, 5000);
	        	tableUsers.get();
			},
			error: function(err){
				var res = JSON.parse(err.responseText);
	        	var notiStr = '<strong>error</strong> '+ res.message;
	        	notify.setType('alert-warning');
	        	notify.open(notiStr, 5000);
			}
		});
	}
	var confirmBtn = modal.find('.btn-confrim');
	confirmBtn.click(function(){
		myDelete();
	});
	modal.open = function(){
		this.find('.modal-body').html("do you sure to delete <strong>"+name+"</strong> ?");
		this.modal('show');
	};
	modal.close = function(){
		modal.modal('hide');
	}
	modal.deleteUser = function(user){
		name = user.name;
		id = user.id;
		this.open();
	}
	return modal;
}());
var modalUser = (function(){
	var selector = '#user-modal';
	var getUrl = "http://localhost/enkulu_task/index.php/user/info/";
	var addUrl = "http://localhost/enkulu_task/index.php/user/add";
	var updateUrl = "http://localhost/enkulu_task/index.php/user/update/";
	var modal = $(selector);
	var job = 'add';
	var updateId = null;

	function post(id){
		//var data = $('#user-form').serialize(); 
		var data = new FormData($('#user-form')[0]);
		var url = addUrl;
		if(job == 'update') url = updateUrl + updateId;
		$.ajax({
			url: url,
			data: data,
//			dataType: 'json',
			type: 'POST',
			contentType: false,
	        cache: false,
	        processData: false,
	        success: function(response){
	        	var notiStr = '<strong>success</strong> '+ response.message;
	        	notify.setType('alert-success');
	        	notify.open(notiStr, 5000);
				tableUsers.get();
				modal.close();
	        },
	        error: function(err){
	        	var res = JSON.parse(err.responseText);
	        	var notiStr = '<strong>error</strong> '+ res.message;
	        	notify.setType('alert-warning');
	        	notify.open(notiStr, 5000);
	        	modalUser.error(res.data);
	        }

		});
	}
	function get(id){
		$.ajax({
			url: getUrl + id,
			type: 'GET',
			dataType: 'json',
			success: function(response){
				job = 'update';
				modalUser.render(response.data);
				modalUser.open();
			},
			error: function(err){
				var res = JSON.parse(err.responseText);
	        	var notiStr = '<strong>error</strong> '+ res.message;
	        	notify.setType('alert-warning');
	        	notify.open(notiStr, 5000);
			}
		});
	}
	
	modal.find('#user-submit').click(function(){
		post();
	});
	modal.find('buton.close').click(function(){
		modal.close();
	})
	modal.render = function(user){
		var keys = Object.keys(user);
		for(var key of keys){
			$("input[name="+ key +"]").val(user[key]);
		}
	}
	modal.clear = function(){
		var user = {
			name: "",
			email: "",
			phone: ""
		};
		this.render(user);
	}
	modal.open = function(){
		$(selector).modal('show');
	}
	modal.close = function(){
		$(selector).modal('hide');
	}
	modal.addUser = function(){
		//clear
		modal.clear();
		modal.open();
		job = 'add';
	}
	modal.updateUser = function(user){
		updateId = user.id;
		job = 'update';
		get(updateId);
	}
	modal.deleteUser = function(id){
		delete(id);
	}
	modal.error = function(err){
		var keys = Object.keys(err);
		for(var key of keys){
			$("small[for="+ key +"].text-muted").text(err[key]);
		}
	}

	return modal;
}());
$(document).ready(function(){
	//modalUser.show();
	tableUsers.get();

	$(document).on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});
});
