<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/main.css')}}">
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="todolist not-done">
                <button id="checkAll" class="btn btn-success">Show All Task</button>
             <h1>Tasks</h1>
                <input type="text" class="form-control add-todo" placeholder="Add todo">
                    
                    <hr>
                    <ul id="sortable" class="list-unstyled">
                    @foreach($data as $value)
                    <li class="ui-state-default">
                        <button class="pull-right btn btn-danger remove-item" value="{{$value->id}}">Delete</button>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" @if($value->completed) checked @endif value="{{$value->id}}" />{{$value->title}}</label>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.all.min.js"></script>
<script> 
$("#sortable").sortable();
$("#sortable").disableSelection();



// all done btn
$("#checkAll").click(function(){
    $.ajax({
        url: "{{url('show-all')}}",
        type: "GET",
        dataType: 'json',
        success: function (result) {
            if(result.status == 1) {
                $('.ui-state-default').remove();
                $.each(result.data, function (key, value) {
                    if(value.completed == 1){
                        var checked = "checked";
                    }
                    else{
                        var checked = "";
                    }
                    $("#sortable").append('<li class="ui-state-default"><button class="pull-right btn btn-danger remove-item" value="' + value.id + '">Delete</button><div class="checkbox"><label><input type="checkbox"'+ checked +' value="'+ value.id + '">' + value.title + '</label></div></li>');
                });
            }
            
        }
    });
    $('h1').html('All Tasks');
    $('#checkAll').remove();
});

//create todo
$('.add-todo').on('keypress',function (e) {
      e.preventDefault
      if (e.which == 13) {
           if($(this).val() != ''){
           var todo = $(this).val();

            $.ajax({
                url: "{{url('store')}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    todo: todo
                },
                dataType: 'json',
                success: function (result) {
                    if(result.status == 1) {
                        $("#sortable").append('<li class="ui-state-default"><button class="pull-right btn btn-danger remove-item" value="' + result.data.id + '">Delete</button><div class="checkbox"><label><input type="checkbox" value="'+ result.data.id + '">' + result.data.title + '</label></div></li>');
                    }
                    
                }
            });
           }else{
               // some validation
           }
            $(this).val('');
      }
});

// mark task as done
$('.todolist').on('change','#sortable li input[type="checkbox"]',function(){
    if($(this).prop('checked')){
        var id = $(this).val();
        $.ajax({
            url: "{{url('complete')}}/" + id,
            type: "PUT",
            data: {"_token": "{{ csrf_token() }}"},
            dataType: 'json',
            success: function (result) {
            }
        });
        var doneItem = $(this).parent().parent().find('label').text();
        $(this).parent().parent().parent().addClass('remove');
        done(doneItem);

        
    }
});

//delete task
$('.todolist').on('click','.remove-item',function(){
    var id = $(this).val();
    Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            removeItem(this);
            $.ajax({
            url: "{{url('delete')}}/" + id,
            type: "DELETE",
            data: {"_token": "{{ csrf_token() }}"},
            dataType: 'json',
            success: function (result) {
            }
        });
          }
        })
    
        
        countTodos();
});


//mark task as done
function done(doneItem){
    var done = doneItem;
    var markup = '<li>'+ done +'<button class="btn btn-default btn-xs pull-right  remove-item"><span class="glyphicon glyphicon-remove"></span></button></li>';
    $('#done-items').append(markup);
    $('.remove').remove();
}

//remove done task from list
function removeItem(element){
    $(element).parent().remove();
}
 </script>