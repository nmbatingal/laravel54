@extends('layouts.print-layout')

<!-- TITLE -->
@section('title')
    Print | Selection Lineup - 
@endsection

<!-- CASCADING STYLE SHEET -->
@section('styles')
<style>
    body {
        font-size: 8pt;
        font-family: "Calibri";
    }

    .text-center {
        text-align: center !important;
    }

    .text-right {
        text-align: right !important;
    }

    .text-left {
        text-align: left !important;
    }

    .table {
        border-top: 1px solid #000000 !important;
        border-right: 1px solid #000000 !important;
        border-left: 1px solid #000000 !important;
        border-bottom: 1px solid #000000 !important;
        width: 100%;
        border-collapse: collapse;
        padding: 5px;
        table-layout: fixed;
        word-wrap:break-word;
    }
    
    .lineup-table {
        border: 0 !important;
    }
    
    .lineup-list th {
        border: 1px solid #000;
        border-collapse: collapse;
    }
    
    .lineup-list td.border {
        border-left: 1px solid #000;
        border-right: 1px solid #000;
    }
    
    .lineup-list td {
    }

    @page {
        size: A4 landscape;
        margin: 2mm 8mm;
    }

    @media print {
        body {
            margin: 0mm !important;
        }
        .page {
            margin: 0mm !important;
        }

        .no-print {
            display: none;
        }
    }
</style>
@endsection('styles')

@section('content')
    <div class="no-print">
        <button onclick= "window.print()"><i class="fa fa-print fa-fw"></i> Print</button>
        <br><br>    
    </div>
    
    <div class="page">
        <table class="table lineup-table">
            <colgroup>
                <col width="10%" />
                <col width="10%" />
                <col width="80%" />
            </colgroup>
            <tr>
                <td colspan="3" class="text-center">SELECTION LINE-UP OF APPLICANTS</td>
            </tr>
            <tr>
                <td>Position Title</td>
                <td colspan="2">: {{ $selection->position['title'] }}</td>
            </tr>
            <tr>
                <td>Publication No.</td>
                <td colspan="2">: 
                    <?php
                        $publication = explode(',', $selection->position->publications[0]['publication_no']);

                        foreach ($publication as $value) {
                            echo $value.'; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        }
                    ?>                    
                </td>
            </tr>
            <tr>
                <td>Item No.</td>
                <td colspan="2">: 
                    <?php
                        $item = explode(',', $selection->position->items[0]['item_no']);

                        foreach ($item as $value) {
                            echo $value.'; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        }
                    ?>                
                </td>
            </tr>

            <tr>
                <td>Salaray Grade</td>
                <td colspan="2">: {{ $selection->position['sal_grade'] }}</td>
            </tr>

            <tr>
                <td rowspan="4" style="vertical-align:text-top">Qualification Standards</td>
                <td>: Education</td>
                <td> - {{ $selection->position->qualifications[0]['education'] }}</td>
            </tr>

            <tr>
                <td>&nbsp;&nbsp;Experience</td>
                <td> - {{ $selection->position->qualifications[0]['experience'] }}</td>
            </tr>

            <tr>
                <td>&nbsp;&nbsp;Trainings</td>
                <td> - {{ $selection->position->qualifications[0]['trainings'] }}</td>
            </tr>

            <tr>
                <td>&nbsp;&nbsp;Eligibilities</td>
                <td> - {{ $selection->position->qualifications[0]['eligibilities'] }}</td>
            </tr>
        </table>  
        
        <br>
        <br>
        
        <table class="table lineup-list">
            <thead>
                <tr>
                    <th style="padding: 5px;" width="3%" valign="top" class="lineup-list" scope="col">&nbsp;</th>
                    <th style="padding: 5px;" width="18%" scope="col">Name</th>
                    <th style="padding: 5px;" width="18%" scope="col">Education</th>
                    <th style="padding: 5px;" width="18%" scope="col">Relevant trainings</th>
                    <th style="padding: 5px;" width="18%" scope="col">Work Experience</th>
                    <th style="padding: 5px;" width="18%" scope="col">Eligibility</th>
                    <th style="padding: 5px;" width="8%" scope="col">Performance Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    $applicant = count($group);
                    foreach ($group as $i => $selection) {
                        $itemlines = 0;
                        $temp      = 0;

                ?>      <tr>
                            <td valign="top" class="lineup-list border" style="text-align: center; padding: 5px;"> {{ $i + 1 }} </td>
                            <td align="left" valign="top" class="border" style="padding: 5px;">
                                <?php
                                    $name = $selection->applicant['lastname'] . ', ' . $selection->applicant['firstname'].'&nbsp;'; 
                                    $name .= !empty($selection->applicant['middlename']) ? $selection->applicant['middlename'][0].'.' : '';
                                    echo $name;

                                    $itemlines  = intval(strlen($name) / 30);
                                    $temp       = $itemlines;

                                ?>
                            </td>
                            <td align="left" valign="top" class="border" style="padding: 5px;">
                                <?php
                                    $education = '';
                                    foreach ( $selection->applicant->educations as $educations ) {
                                        $education  = $educations['program'] .' - '. $educations['school'] .', '. date("M-d-y", strtotime($educations['year'])) .'<br />';
                                        echo $education;
                                    }

                                    $itemlines = intval(strlen($education) / 30);
                                    if ( $itemlines > $temp ) {
                                        $temp = $itemlines;
                                    }
                                ?>
                            </td>
                            <td align="left" valign="top" class="border" style="padding: 5px;">
                                <?php
                                    $training = '';
                                    foreach ( $selection->applicant->trainings as $trainings ) {
                                        $training  = $trainings['title'] .' - '.  $trainings['conducted_by'] .', '. date("M-d-y", strtotime($trainings['from_date'])) . '<br />';
                                        echo $training;
                                    }

                                    $itemlines = intval(strlen($training) / 30);
                                    if ( $itemlines > $temp ) {
                                        $temp = $itemlines;
                                    }
                                ?>
                            </td>
                            <td align="left" valign="top" class="border" style="padding: 5px;">
                                <?php
                                    $experience = '';
                                    foreach ( $selection->applicant->experiences as $experiences ) {
                                        $experience  = $experiences['position'] . ', '. $experiences['agency'] . ' - ' . date("Y", strtotime($experiences['to_date'])) . '<br />';
                                        echo $experience;
                                    }

                                    $itemlines = intval(strlen($experience) / 30);
                                    if ( $itemlines > $temp ) {
                                        $temp = $itemlines;
                                    }
                                ?>
                            </td>
                            <td align="left" valign="top" class="border" style="padding: 5px;">
                                <?php
                                    $eligibility = '';
                                    foreach ( $selection->applicant->eligibilities as $eligibilities ) {
                                        $eligibility  = $eligibilities['title'] . '; ';
                                        echo $eligibility;
                                    }

                                    $itemlines = intval(strlen($eligibility) / 30);
                                    if ( $itemlines > $temp ) {
                                        $temp = $itemlines;
                                    }
                                ?>
                            </td>
                            <td align="left" valign="top" class="border" style="padding: 5px;">
                            </td>
                        </tr>
                <?php
                        $applicant += $temp;
                    }

                    $blanktd = 25;
                    if( $applicant > 25 ){
                        $full_page_count = intval( $applicant / 32 );
                        if ( $full_page_count > 0 ) {
                            $rem = intval( $applicant % 32 );
                            if ( $rem == 24 ) {
                                $blanktd = 0;
                            } elseif ( $rem > 24 ) {
                                $blanktd = 32 - ( $rem % $blanktd );
                            } else {
                                $blanktd -= $rem % $blanktd;    
                            }
                            $blanktd -= $rem % $blanktd;
                        } else {
                            $blanktd += 32 - $applicant;
                        }
                    } else {
                        $blanktd -= $applicant;
                    }

                    while ( $blanktd > 0)
                    {
                        echo 
                        '<tr>
                            <td align="left" valign="top" class="border" style="padding: 5px;">&nbsp;</td>
                            <td align="left" valign="top" class="border" style="padding: 5px;"></td>
                            <td align="left" valign="top" class="border" style="padding: 5px;"></td>
                            <td align="left" valign="top" class="border" style="padding: 5px;"></td>
                            <td align="left" valign="top" class="border" style="padding: 5px;"></td>
                            <td align="left" valign="top" class="border" style="padding: 5px;"></td>
                            <td align="left" valign="top" class="border" style="padding: 5px;"></td>
                        </tr>';

                        $blanktd--;
                    }

                ?>
            </tbody>
        </table>

    </div>
@endsection