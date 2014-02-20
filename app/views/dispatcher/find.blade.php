<header><h2>{{$title}}</h2></header>
<div class='event-forms'>
    @if($errors->has())
    <div class="alert alert-danger">
        {{ HTML::ul($errors->all()) }}
    </div>
    @endif

    <div id='recurringEvent'>  
        {{ Form::open(array('action' => 'DispatchController@fetchResult', 'method' => 'post', 'class' => 'form-horizontal')) }}
        <div class="form-group">
            {{ Form::label('weekdays', 'Weekdays:', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-xs-3">
                <select class="form-control" name="weekday">
                    <option value="">Please Select</option>
                    @foreach($weekdays as $key => $weekday)
                    <option value="{{ $key }}">{{ $weekday }}</option>
                    @endforeach
                </select>

            </div>
        </div>

        <div class="form-group">
            {{ Form::label('dates', 'Dates:', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-xs-3">
                <select class="form-control" name="date">
                    <option value="">Please Select</option>
                    @foreach($currentMonthDates as $key => $cmd)
                    <option value="{{ $key }}">{{ $cmd }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('month', 'Months:', array('class' => 'col-sm-2 control-label')) }}
            <div class="col-xs-3">
                <select class="form-control" name="month">
                    <option value="">Please Select</option>
                    @foreach($months as $key => $month)
                    <option value="{{ $key }}">{{ $month }}</option>
                    @endforeach
                </select>
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