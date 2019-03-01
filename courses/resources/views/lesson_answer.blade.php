
<div class="lessons_sequence lessons_sequence_answer">
    <?php
    if(!empty($lesson)){

    foreach ($lesson as $index => $value){
    if($value->subject_type_id != $sub_id){
        continue;
    }

    if($value->status == 1 && Auth::user()->payment_charge == 1){
        continue;
    }
    ?>
    <ul class="tablinks" onclick="opencourse(event, '{{$value->subject_name}}', '{{$value->id}}')">
        <li>
{{--start lesson--}}
        </li>
        <li>
            <h3 dir="rtl">{{ $value->name}}</h3>
            <p class="course_title">{{ $value->title}}</p>
        </li>
        <li>
            <div class="duration">
                <p dir="rtl"><i class="far fa-clock"></i> {{ $value->lesson_time}} m. </p>
            </div>
        </li>
    </ul>

    <?php } } ?>
</div>