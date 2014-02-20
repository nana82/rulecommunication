<header><h2>{{$title}}</h2></header>

@foreach ($dispatchers as $dispatcher)
<div class="well well-lg">
    <h4>Dispatch ID: {{$dispatcher->dispatch_id }}</h4>
    <p><span class='bold'>Day:</span> {{$dispatcher->day }}</p>
    <?php if (!empty($dispatcher->date)) { ?>
    <p><span class='bold'>Date:</span> {{$dispatcher->date }}</p>
    <?php } ?>
    <p><span class='bold'>Month:</span> {{$dispatcher->month }}</p>
    <p><span class='bold'>Year:</span> {{$dispatcher->year }}</p>
    <p><span class='bold'>Time:</span> {{$dispatcher->time }}</p>
    <p><span class='bold'>Repeat:</span> {{$dispatcher->repeat }}</p>
</div>
@endforeach

<?php echo $dispatchers->appends(array('date' => $date, 'day' => $day, 'month' => $month))->links(); ?>