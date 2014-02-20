<header><h2>{{$title}}</h2></header>
<div class='event-forms'>
    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @if($errors->has())
    <div class="alert alert-danger">
        {{ HTML::ul($errors->all()) }}
    </div>
    @endif

    <!-- start of single event form -->
    <div id='singleEvent'>
        {{ Form::open(array('action' => 'DispatchController@storeSingleDispatcher', 'method' => 'post', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            {{ Form::label('date', 'Event Date:', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-xs-8">
                {{ Form::text('date', null, array('class' => 'form-control',  'id' => 'datetimepicker6', 'data-format' => "YYYY-MM-DD hh:mm")) }}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {{ Form::submit('Submit!', array('class' => 'btn btn-primary')) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>


</div>
<script type="text/javascript">
    $(function() {
        $('#datetimepicker6').datetimepicker();
    });
</script>