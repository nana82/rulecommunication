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

    <!-- start of recurring form -->
    <div id='recurringEvent'>
        {{ Form::open(array('action' => 'DispatchController@storeRecurringDispatcher', 'method' => 'post', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            {{ Form::label('weekdays', 'Weekdays:', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-xs-3">
                {{ Form::select('weekdays[]', $weekdays, null, array('multiple', 'class' => 'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('dates', 'Dates:', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-xs-3">
                {{ Form::select('dates[]', $currentMonthDates, null, array('multiple', 'class' => 'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('month', 'Months:', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-xs-3">
                {{ Form::selectMonth('months[]', null, array('multiple', 'class' => 'form-control')) }}
            </div>
        </div>
        
        <div class="form-group">
            {{ Form::label('time', 'Time:', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-xs-3">
                {{ Form::select('time', $time, null, array('class' => 'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('repeat', 'Repeat:', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-xs-2">
                {{ Form::text('repeat', '0', array('class' => 'form-control')) }}
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