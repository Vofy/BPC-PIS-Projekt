@extends('layout')

@section('title', 'Vzdělání')

<?php

$evaluations = DB::table('evaluations')
    ->select('*')
    ->join('courses', 'evaluations.course_id', 'courses.id')
    ->orderByRaw('courses.id ASC, evaluations.semester ASC')
    ->get();

$best_grade = DB::table('evaluations')
    ->select('course_id', 'grade')
    ->join('courses', 'evaluations.course_id', 'courses.id')
    ->where('grade', '<>', '')
    ->min('grade');

$worst_grade = DB::table('evaluations')
    ->select('course_id', 'grade')
    ->join('courses', 'evaluations.course_id', 'courses.id')
    ->where('grade', '<>', '')
    ->max('grade');
?>

@section('content')
    <section class="m-5">
        <h1>Vzdělání</h1>

        <div class="my-3">
            <h2>Střední škola</h2>
            <div class='jumbotron p-3'>
            Střední průmyslová škola a Střední odborná škola Dvůr Králové nad Labem - 18–20–M/01 Informační technologie (se zaměřením na vývoj aplikací)
        </div>
        </div>

        <div class="my-3">
            <h2>Vyská škola</h2>
            
            <?php

                $last_semester = 0;

                foreach($evaluations as $evaluation)
                {
                    // Pokud se změnil semestr
                    if($evaluation->semester > $last_semester)
                    {
                        if($last_semester != 0)
                            print("</table></div><br>");

                        printf("
                            <h3>%d. Semestr</h3>
                            <div class='jumbotron p-3'>
                                <table class='w-100'>
                                    <tr>
                                        <th scope='col'>Zkratka</th>
                                        <th scope='col'>Předmět</th>
                                        <th scope='col' class='text-center'>Zápočet</th>
                                        <th scope='col' class='text-center'>Počet bodů</th>
                                        <th scope='col' class='text-center'>Známka</th>
                                    </tr>", 
                            $evaluation->semester);

                        $last_semester = $evaluation->semester;
                    }

                    printf("
                        <tr>
                            <td>%s</td>
                            <td>%s</td>
                            <td class='text-center'>%s%s</td>
                            <td class='text-center'>%s</td>
                            <td class='text-center'><b>%s</b>%s</td>
                        </tr>", 
                        $evaluation->abbreviation, 
                        $evaluation->title,
                        $evaluation->credit ? ($evaluation->credits_given_date ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-xmark"></i>') : '-',
                        ($evaluation->credit && $evaluation->credits_given_date) ? ' (' . $evaluation->credits_given_date . ')' : '',
                        ($evaluation->graded_credit || $evaluation->examination) ? $evaluation->points : '-',
                        ($evaluation->examination || $evaluation->graded_credit) ? ($evaluation->grade ? $evaluation->grade : '') : '-',
                        $evaluation->grade_date ? ' (' . $evaluation->grade_date . ')' : ''
                    );
                    
                }

                print("</table></div>");
            ?>
            <br>
            <b> 
                <?php
                    $sum_weighted_marks = 0;
                    $sum_credits = 0;

                    foreach($evaluations as $evalution)
                    {
                        
                        if     ($evalution->grade == 'A') $mark = 1;
                        else if($evalution->grade == 'B') $mark = 1.5;
                        else if($evalution->grade == 'C') $mark = 2;
                        else if($evalution->grade == 'D') $mark = 2.5;
                        else if($evalution->grade == 'E') $mark = 3;
                        else if($evalution->grade == 'F') $mark = 4;
                        else                               $mark = 0;

                        $sum_weighted_marks += $mark * $mark * $evaluation->credits;
                        $sum_credits += $evaluation->credits;
                    }

                    $average = $sum_weighted_marks / $sum_credits;

                    printf("Vážený studijní průměr: %1.2f<br>", $average);
                    printf("Nejlepší známka: %s<br>", $best_grade);
                    printf("Nejhorší známka: %s<br>", $worst_grade);
                ?>
            </b>
        </div>
    </section>
@stop