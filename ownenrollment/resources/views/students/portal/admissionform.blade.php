<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="icon" type="image/png" href="{{ asset('img/dorsu.png') }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>{{ __('Register') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
        <!-- CSS Files -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet"/>
        <link rel="stylesheet" href="{{ asset('css/enroll.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
        <script src="{{ asset('light-bootstrap/js/core/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>
    </head>

    <body>
        <div class="wrapper wrapper-full-page">
            <div class="col-12 text-right p-3">
                <a href="/close" onclick="window.close()" class="text-dark text-lg back-btn">Back to Cloud Space</a>
            </div>
            <div class="container-fluid">
                <div class="info-cont">
                    <div class="col-lg-10 m-auto">
                        <div id="newstudform" class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <h1 style="text-align: center; margin-top: 20px; margin-bottom: 20px; font-family: CENTURY GOTHIC;">STUDENT INFORMATION PROFILE</h1>
                            </div>
                            <form id="insertstud" method="post" action="{{ route('storestudent') }}" enctype="multipart/form-data" class="needs-validation" novalidator>
                                <div class="card-body row g-3">
                                    <div class="col-md-4">
                                        <div class="col-12">
                                            <img id="pro-image" src="@if(($info->profile ?? '') == '') img/human.png @else data:image/png;base64,{{$info->profile}} @endif" class="col-md-12">
                                            <button id="custom-btn" class="col-md-12 btn btn-outline-info mt-3 mb-3" type="button">CHOOSE IMAGE</button>
                                        </div>
                                        <input type="file" class="form-control" hidden id="customFile" name="image" accept="image/*">
                                        <input type="hidden" name="hdn_image" value="{{$info->profile ?? ''}}">
                                        <div id="image-invalid" class="invalid-feedback">Please provide an image</div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="col-12 p-0">
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label class="form-label">School ID</label>
                                                    <input type="text" name="studentId" value="{{$info->id ?? ''}}" id="studentId" class="form-control required" placeholder="School ID" required>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label class="form-label">LRN</label>
                                                    <input type="text" name="lrn" id="lrn" value="{{$info->lrn ?? ''}}" class="form-control required" placeholder="Learner Reference Number (LRN)" onkeyup="NumbersOnly(this)" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 p-0">
                                            <input type="text" name="fname" value="{{$info->first_name ?? ''}}" id="fname" class="form-control required" placeholder="First name" required>
                                        </div>
                                        <div class="col-12 p-0">
                                            <input type="text" name="mname" id="mname" value="{{$info->middle_name ?? ''}}" class="form-control" placeholder="Middle name">
                                        </div>
                                        <div class="col-12 p-0">
                                            <input type="text" name="lname" id="lname" value="{{$info->last_name ?? ''}}" class="form-control required" placeholder="Last name" required>
                                        </div>
                                        <div class="col-md-4 pl-0">
                                            <div class="invalid-feedback">Please fill all the needed information</div>
                                            <input type="text" name="suffix" id="suffix" value="{{$info->suffix ?? ''}}" class="form-control" placeholder="Suffix">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Age:</label>
                                        <input name="age" class="form-control required" id="age" value="{{$info->age ?? ''}}" type="text" onkeyup="NumbersOnly(this)" required>
                                        <div class="invalid-feedback">Please enter your age</div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Birthdate:</label>
                                        <input name="birthdate" type="date" value="{{$info->birthdate ?? ''}}" id="db" class="form-control required"
                                            required>
                                        <div class="invalid-feedback">Please select your birthdate</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Gender:</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="1">Male</option>
                                            <option @if($info->gender ?? 1 == 0 )selected @endif value="0">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Civil Status:</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="Single">Single</option>
                                            <option @if($info->civil_status ?? '' == 'Married')selected @endif value="Married">Married</option>
                                            <option @if($info->civil_status ?? '' == 'Widowed')selected @endif value="Widowed">Widowed</option>
                                            <option @if($info->civil_status ?? '' == 'Separated')selected @endif value="Separated">Separated</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Citizenship:</label>
                                        <div class="col-sm-12 p-0">
                                            <input name="citizenship" value="{{$info->citizenship ?? ''}}" class="form-control required" type="text" required>
                                            <div class="invalid-feedback">Enter your citizenship</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <label class="form-label">Height:</label>
                                            <div class="col-sm-12 pl-0">
                                                <input name="height" value="{{$info->height ?? ''}}" class="form-control required" onkeyup="NumbersOnly(this)"
                                                    type="text" required>
                                                <div class="invalid-feedback">Enter your height</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <label class="form-label">Weight:</label>
                                            <div class="col-sm-12 pl-0">
                                                <input name="weight" value="{{$info->weight ?? ''}}" class="form-control required" placeholder="Kilogram" onkeyup="NumbersOnly(this)"
                                                    type="text" required>
                                                <div class="invalid-feedback">Enter your Weight</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Place of Birth:</label>
                                        <div class="col-sm-12 p-0">
                                            <input name="birthplace" value="{{$info->birthplace ?? ''}}" id="birthplace" class="form-control required"
                                                type="text" required>
                                            <div class="invalid-feedback">Enter your birth address</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Residential Address:</label>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                @php
                                                
                                                    $rAddress = explode('| ',$info->r_address ?? '| | | ')
                                                @endphp
                                                <input name="res-add" class="form-control required" value="{{$rAddress[0]}} "
                                                 type="text" placeholder="Residential Address" required>
                                                <div class="invalid-feedback">Enter your residential address</div>
                                            </div>
                                            <div class="col-sm-7">
                                                <input name="res-city" type="text" value="{{$rAddress[1]}}" class="form-control required"
                                                placeholder="City" required>
                                                <div class="invalid-feedback">In what city were you resided</div>
                                            </div>
                                            <div class="col-sm">
                                                <input name="res-state" type="text" value="{{$rAddress[2]}}" class="form-control required"
                                                placeholder="State" required>
                                                <div class="invalid-feedback">In what state were you resided </div>
                                            </div>
                                            <div class="col-sm">
                                                <input name="res-zip" type="text" value="{{$rAddress[3]}}" class="form-control required"
                                                placeholder="Zip" onkeyup="NumbersOnly(this)" required>
                                                <div class="invalid-feedback">Please provide a valid zip</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class=" form-label">Current Address:</label>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                @php
                                                    $cAddress = explode('| ',$info->c_address ?? '| | | ')
                                                @endphp
                                                <input name="cur-add" value="{{$cAddress[0]}}" class="form-control required"
                                                    type="text" placeholder="Current Address" required>
                                                <div class="invalid-feedback">Enter your residential address</div>
                                            </div>
                                            <div class="col-sm-7">
                                                <input name="cur-city" type="text" value="{{$cAddress[1]}}" class="form-control required"
                                                placeholder="City" required>
                                                <div class="invalid-feedback">In what city were you resided</div>
                                            </div>
                                            <div class="col-sm">
                                                <input name="cur-state" id="cur-state" type="text" value="{{$cAddress[2]}}" class="form-control required"
                                                placeholder="State" required>
                                                <div class="invalid-feedback">In what state were you resided </div>
                                            </div>
                                            <div class="col-sm">
                                                <input name="cur-zip" id="cur-zip" type="text" value="{{$cAddress[3]}}" class="form-control required"
                                                placeholder="Zip" onkeyup="NumbersOnly(this)" required>
                                                <div class="invalid-feedback">Please provide a valid zip</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Ethnic Origin:</label>
                                        <select name="ethnic" id="ethnic" class="form-control">
                                            <option value="Abaknon">Abaknon</option>
                                            <option value="Agta">Agta</option>
                                            <option value="Agutaynon">Agutaynon</option>
                                            <option value="Aklanon">Aklanon</option>
                                            <option value="Alangan">Alangan</option>
                                            <option value="Alta">Alta</option>
                                            <option value="Amerisian">Amerisian</option>
                                            <option value="Ati">Ati</option>
                                            <option value="Ayta (Aeta)">Ayta (Aeta)</option>
                                            <option value="B'laan">B'laan</option>
                                            <option value="Badjao">Badjao</option>
                                            <option value="Bagobo">Bagobo</option>
                                            <option value="Balangao">Balangao</option>
                                            <option value="Balangingi">Balangingi</option>
                                            <option value="Bangon">Bangon</option>
                                            <option value="Bantoanon">Bantoanon</option>
                                            <option value="Banwaon">Banwaon</option>
                                            <option value="Batak">Batak</option>
                                            <option value="Bicolano">Bicolano</option>
                                            <option value="Binukid">Binukid</option>
                                            <option value="Boholano">Boholano</option>
                                            <option value="Bolinao">Bolinao</option>
                                            <option value="Bontoc">Bontoc</option>
                                            <option value="Buhid">Buhid</option>
                                            <option value="Butuanon">Butuanon</option>
                                            <option value="Caluyanon">Caluyanon</option>
                                            <option value="Capiznon">Capiznon</option>
                                            <option value="Cavitenyo">Caviteño</option>
                                            <option value="Cebuano">Cebuano</option>
                                            <option value="Cotabatenyo">Cotabateño</option>
                                            <option value="Cuyonon">Cuyonon</option>
                                            <option value="Chinese Filipinos">Chinise Filipinos</option>
                                            <option value="Davaoenyo">Davaoeño</option>
                                            <option value="Ermitenyo">Ermieño</option>
                                            <option value="Ga'dang">Ga'dang</option>
                                            <option value="Gaddang">Gaddang</option>
                                            <option value="Hanunoo">Hanunoo</option>
                                            <option value="Higaonon">Higaonon</option>
                                            <option value="Ibaloi">Ibaloi</option>
                                            <option value="Ibanag">Ibanag</option>
                                            <option value="Ifugao">Ifugao</option>
                                            <option value="Ikalahan">Ikalahan</option>
                                            <option value="Illanun">Illanun</option>
                                            <option value="Ilocano">Ilocano</option>
                                            <option value="Ilonggo">Ilonggo</option>
                                            <option value="Ilongot">Ilongot</option>
                                            <option value="Indian Filipinos">Indian Filipinos</option>
                                            <option value="Inonhan">Inonhan</option>
                                            <option value="Iraya">Iraya</option>
                                            <option value="Isinai">Isinai</option>
                                            <option value="Isneg">Isneg</option>
                                            <option value="Itneg">Itneg</option>
                                            <option value="Ivatan">Ivatan</option>
                                            <option value="Japanese Filipinos">Japanese Filipinos</option>
                                            <option value="Kagayanen">Kagayanen</option>
                                            <option value="Kalagan">Kalagan</option>
                                            <option value="Kalinga">Kalinga</option>
                                            <option value="Kamayo">Kamayo</option>
                                            <option value="Kankanaey">Kankanaey</option>
                                            <option value="Kapampangan">Kapampangan</option>
                                            <option value="Karao">Karao</option>
                                            <option value="Kasiguranin">Kasiguranin</option>
                                            <option value="Kinaray-a">Kinaray-a</option>
                                            <option value="Kinamiguin">Kinamiguin</option>
                                            <option value="Kolibugan">Kolibugan</option>
                                            <option value="Korean Filipinos">Korean Filipinos</option>
                                            <option value="Magahat">Magahat</option>
                                            <option value="Maguindanao">Maguindanao</option>
                                            <option value="Malaweg">Malaweg</option>
                                            <option value="Mamanwa">Mamanwa</option>
                                            <option value="Mandaya">Mandaya</option>
                                            <option value="Mansaka">Mansaka</option>
                                            <option value="Manguwangan">Manguwangan</option>
                                            <option value="Manobo">Manobo</option>
                                            <option value="Matigsalug">Matigsalug</option>
                                            <option value="Maranao">Maranao</option>
                                            <option value="Masbatenyo">Masbaño</option>
                                            <option value="Molbog">Molbog</option>
                                            <option value="Negrense">Negrense</option>
                                            <option value="Palawano">Palawano</option>
                                            <option value="Pangasinense">Pangasinense</option>
                                            <option value="Paranan">Paranan</option>
                                            <option value="Porohanon">Porohanon</option>
                                            <option value="Ratagnon">Ratagnon</option>
                                            <option value="Romblomanon">Romblomanon</option>
                                            <option value="Sama">Sama</option>
                                            <option value="Sambal">Sambal</option>
                                            <option value="Sangil">Sangil</option>
                                            <option value="Spanish Filipinos">Spanish Filipinos</option>
                                            <option value="Subanun">Subanun</option>
                                            <option value="Sulod">Sulod</option>
                                            <option value="Surigaonon">Surigaonon</option>
                                            <option value="T'boli">T'boli</option>
                                            <option value="Tadyawan">Tadyawan</option>
                                            <option value="Tagabawa">Tagabawa</option>
                                            <option value="Tagakaulo">Tagakaulo</option>
                                            <option value="Tagalog" selected>Tagalog</option>
                                            <option value="Tagbanwa">Tagbanwa</option>
                                            <option value="Talaandig">Talaandig</option>
                                            <option value="Tasaday">Tasaday</option>
                                            <option value="Tau't Bato">Tau't Bato</option>
                                            <option value="Tausug">Tausug</option>
                                            <option value="Tawbuid">Tawbuid</option>
                                            <option value="Ternatenyo">Ternateño</option>
                                            <option value="Tiruray">Tiruray</option>
                                            <option value="Waray">Waray</option>
                                            <option value="Yakan">Yakan</option>
                                            <option value="Yogad">Yogad</option>
                                            <option value="Zamboanguenyo">Zamboangueño</option>
                                        </select>
                                        <!--<input class="form-control" id="ethnic" name="ethnic" type="text">-->
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Religion:</label>
                                        <input class="form-control" name="religion" id="religion" value="{{$info->religion ?? ''}}" type="text">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Languages/Dialects Fluent In:</label>
                                        <input class="form-control" name="language" id="language" value="{{$info->languages ?? ''}}" type="text">
                                    </div>
                                    <input type="text" hidden name="studtype" id="studtype">
                                    <div class="col-md-12">
                                        <label class="form-label">Contact Information:</label>
                                        <div class="row g2">
                                            <div class="col-sm-4">
                                                <input class="form-control required" value="{{$info->contact_number ?? ''}}" type="text" id="phone" name="contact" placeholder="Cellular Phone No." onkeyup="NumbersOnly(this)" required>
                                                <div class="invalid-feedback">Please provide this contact information
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <input name="email" class="form-control required"
                                                    type="text" value="{{$info->email ?? ''}}" placeholder="Email Address" required>
                                                <div class="invalid-feedback">Please provide this contact information
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <input class="form-control" type="text" value="{{$info->fb_account ?? ''}}" name="fbacc" id="fbacc" placeholder="Facebook Account">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="workingStud" hidden>
                                        <label>Where or whom do you work?</label>
                                        <input class="form-control" id="whomwork" name="optr-no" type="text">
                                    </div>
                                    <div class="card-header col-12">
                                        <h1 style="text-align: center; margin-bottom: 20px 0 20px 0; font-family: CENTURY GOTHIC;">FAMILY BACKGROUND</h1>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">(if married):</label>
                                        <div class="input-group">
                                            <input type="text" name="spousename" value="{{$info->spouse_name ?? ''}}" id="spouse" class="form-control"
                                                placeholder="Name of Spouse">
                                            <input type="text" class="form-control" value="{{$info->spouse_occupation ?? ''}}" placeholder="Occupation" name="spouseoccupation" id="occupation">
                                            <input type="text" name="marriedchildren" value="{{$info->child_number ?? ''}}" id="children" class="col-md-2 form-control"
                                                onkeyup="NumbersOnly(this)" placeholder="No. of Children">
                                        </div>
                                            <div class="invalid-feedback col-12">Please fill all the needed information</div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Father's Name:</label>
                                        <div class="input-group">
                                            @php
                                                $fathersname = explode('| ',$info->fathers_name ?? '| | | | ')
                                            @endphp
                                            <input type="text" name="fafname" value="{{$fathersname[0]}}" id="fafname" class="form-control required"
                                            placeholder="Firstname" required>
                                            <input type="text" name="famname" value="{{$fathersname[1]}}" id="famname" class="form-control"
                                                placeholder="Middlename">
                                            <input type="text" name="falname" value="{{$fathersname[2]}}" id="falname" class="form-control required"
                                            placeholder="Lastname" required>
                                            <div class="col-md-2 pr-0">
                                                <input type="text" name="fasuffix" value="{{$fathersname[3]}}" id="fasuffix" class="form-control"
                                                    placeholder="Suffix">
                                            </div>
                                        </div>
                                            <div class="invalid-feedback">Please fill all the needed information</div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Contact Information (Father):</label>
                                        <div class="row g2">
                                            <div class="col-sm-4">
                                                <input class="form-control" name="facontact" type="text" value="{{$info->fathers_contact_number ?? ''}}" placeholder="Cellular Phone No." onkeyup="NumbersOnly(this)">
                                            </div>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="faaddress" type="text" value="{{$info->fathers_address ?? ''}}" placeholder="Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Employment</label>
                                        <div class="form-group row">
                                            <label style="padding-left: 35px" class="col-sm-4">
                                                <input type="radio" required class="form-check-input" name="fa-work" value="Private" onclick="faemp(0)"> Private
                                            </label>
                                            <label style="padding-left: 35px" class="col-sm-4">
                                                <input type="radio" class="form-check-input" name="fa-work" value="Government" onclick="faemp(0)"> Government</label>
                                            <label style="padding-left: 35px" class="col-sm-4">
                                                <input type="radio" class="form-check-input" name="fa-work" value="Entrepreneurial" onclick="faemp(0)"> Entrepreneurial</label>
                                            <label style="padding-left: 35px" class="col-sm-4">
                                                <input type="radio" class="form-check-input" name="fa-work" value="None" onclick="faemp(0)"> None</label>
                                            <label style="padding-left: 35px" class="col-sm-4">
                                                <input type="radio" class="form-check-input" name="fa-work" id="faofw-radio" onclick="faemp(1)"> OFW where 
                                                <input id="faofw" disabled type="text" class="col-10"></label>
                                            <label style="padding-left: 35px" class="col-sm-4">
                                                <input type="radio" class="form-check-input" name="fa-work" id="faother-radio" onclick="faemp(2)"> Others Specify 
                                                <input disabled type="text" class="col-10" id="faother"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                            @php
                                                $mothersname = explode('| ',$info->mothers_name ?? '| | | ')
                                            @endphp
                                        <label class="form-label">Mother's Maiden Name (Pangalan sa imong mama sa pagka dalaga):</label>
                                        <div class="input-group">
                                            <input type="text" name="mofname" id="mofname" value="{{$mothersname[0]}}" class="form-control required"
                                            placeholder="Firstname" required>
                                            <input type="text" name="momname" id="momname" value="{{$mothersname[1]}}" class="form-control"
                                                placeholder="Middlename sa pagka dalaga">
                                            <input type="text" name="molname" id="molname" value="{{$mothersname[2]}}" class="form-control required"
                                            placeholder="Lastname (Apilyedo sa pagka dalaga)" required>
                                            <div class="col-md-2 pr-0">
                                                <input type="text" name="mosuffix" id="mosuffix" value="{{$mothersname[3]}}" class="form-control"
                                                    placeholder="Suffix">
                                            </div>
                                        </div>
                                        <div class="invalid-feedback col-12">Please fill all the needed information</div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Contact Information (Mother):</label>
                                        <div class="row g2">
                                            <div class="col-sm-4">
                                                <input class="form-control" name="mocontact" value="{{$info->mothers_contact_number ?? ''}}"
                                                    type="text" placeholder="Cellular Phone No" onkeyup="NumbersOnly(this)">
                                            </div>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="moaddress" value="{{$info->mothers_address ?? ''}}"
                                                    type="text" placeholder="Address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Employment</label>
                                        <div class="form-group row">
                                            <label style="padding-left: 35px" class="col-sm-4"><input type="radio"
                                                    class="form-check-input" required name="mo-work" value="Private"
                                                    onclick="moemp(0)"> Private</label>
                                            <label style="padding-left: 35px" class="col-sm-4"><input type="radio"
                                                    class="form-check-input" name="mo-work" value="Government" onclick="moemp(0)"> Government</label>
                                            <label style="padding-left: 35px" class="col-sm-4"><input type="radio"
                                                    class="form-check-input" name="mo-work" value="Entrepreneurial"
                                                    onclick="moemp(0)"> Entrepreneurial</label>
                                            <label style="padding-left: 35px" class="col-sm-4"><input type="radio"
                                                    class="form-check-input" name="mo-work" value="None" onclick="moemp(0)"> None</label>
                                            <label style="padding-left: 35px" class="col-sm-4"><input type="radio"
                                                    class="form-check-input" name="mo-work" id="moofw-radio" onclick="moemp(1)"> OFW where 
                                                    <input disabled type="text" class="col-10" id="moofw"></label>
                                            <label style="padding-left: 35px" class="col-sm-4"><input type="radio"
                                                    class="form-check-input" name="mo-work" id="moother-radio" onclick="moemp(2)"> Others Specify 
                                                    <input disabled type="text" class="col-10" id="moother"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Person to Contact in Case of Emergency: </label>
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <input type="text" name="guardian" placeholder="Full name" value="{{$info->guardian ?? ''}}" 
                                                    class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" name="gcontact" placeholder="Contact" value="{{$info->guardians_number ?? ''}}"
                                                    class="form-control">
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" name="gaddress" placeholder="Address" value="{{$info->guardian_address ?? ''}}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Parents are:</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input type="radio" name="optradio2" value="None" checked hidden>
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optradio2"
                                                            value="Living Together"> Living Together
                                                    </label>
                                                    <input type="hidden" name="103" value="589" class="parents_are">
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optradio2"
                                                            value="Temporarily Separated">
                                                        Temporarily Separated
                                                    </label>
                                                    <input type="hidden" name="101" value="605" class="parents_are">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optradio2"
                                                            value="Permanently Separated">
                                                        Permanently Separated
                                                    </label>
                                                    <input type="hidden" name="220" value="589" class="parents_are">
                                                </div>
                                                <div class=" form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optradio2"
                                                            value="Father w/ another partner">
                                                        Father w/ another partner
                                                    </label>
                                                    <input type="hidden" name="257" value="605" class="parents_are">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optradio2"
                                                            value="Marriage Annulled">
                                                        Marriage Annulled
                                                    </label>
                                                    <input type="hidden" name="364" value="589" class="parents_are">
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="optradio2"
                                                            value="Mother w/ another partner">
                                                        Mother w/ another partner
                                                    </label>
                                                    <input type="hidden" name="401" value="605" class="parents_are">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Monthly Family Income: (Estimated)</label>
                                        <input name="famincome" type="text" class="form-control required" value="{{$info->family_monthly_income ?? ''}}"
                                            placeholder="₱" onkeyup="NumbersOnly(this)" required>
                                        <div class="invalid-feedback">Please fill all the needed information</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Guardian(if not living with parents):</label>
                                        <input type="text" name="guardianliving" id="guardian" value="{{$info->guardian_not_living_parents ?? ''}}" class="form-control">
                                    </div>
                                    <div class="col-md-12" style="margin-bottom: 50px;">
                                        <div class="input-group">
                                            <span class="input-group-text">Number of:</span>
                                            <input type="text" class="form-control" name="siblings" value="{{$info->siblings ?? ''}}" placeholder="Siblings" 
                                                onkeyup="NumbersOnly(this)">
                                            <input type="text" class="form-control" name="wsiblings" value="{{$info->working_siblings ?? ''}}" placeholder="Working Siblings"
                                                onkeyup="NumbersOnly(this)">
                                            <input type="text" class="form-control" name="csiblings" value="{{$info->college_siblings ?? ''}}" placeholder="College Siblings"
                                                onkeyup="NumbersOnly(this)">
                                            <input type="text" class="form-control" name="hsiblings"
                                                value="{{$info->hs_siblings ?? ''}}" placeholder="Highschool Siblings" onkeyup="NumbersOnly(this)">
                                        </div>
                                    </div>

                                    <div class="card-header col-12">
                                        <h1 style="text-align: center; margin: 20px 0 20px 0; font-family: CENTURY GOTHIC;">
                                            EDUCATIONAL & CAREER PLAN</h1>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Elementary School:</label>
                                        <div class="input-group">
                                            <input name="elemschool" id="elemschool" type="text" class="form-control required"
                                            value="{{$info->elem_school ?? ''}}" placeholder="Name Of School" required>
                                            <div class="col-md-4 pr-0">
                                                <input type="text" name="elemyear" id="elemyear" class="form-control required"
                                                value="{{$info->elem_year ?? ''}}" placeholder="Year Graduated" required value="" onkeyup="NumbersOnly(this)">
                                            </div>
                                        </div>
                                            <div class="invalid-feedback col-12">Please fill all the needed information</div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Secondary School:</label>
                                        <div class="input-group">
                                            <input name="secschool" id="secschool" value="{{$info->high_school ?? ''}}" type="text" class="form-control required"
                                            placeholder="Name Of School" required>
                                            <div class="col-md-4">
                                                <input type="text" name="strand" id="strand" value="{{$info->strand ?? ''}}" placeholder="Strand"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-4 p-0">
                                                <input type="text" name="secyear" id="secyear" class="form-control required"
                                                placeholder="Year Graduated" required value="{{$info->hs_year ?? ''}}" onkeyup="NumbersOnly(this)">
                                            </div>
                                        </div>
                                            <div class="invalid-feedback col-12">Please fill all the needed information</div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Vocational School:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="vocschool" name="vocschool" value="{{$info->vocational_school ?? ''}}" placeholder="Name Of School">
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" id="voccourse" name="voccourse" value="{{$info->vocational_course ?? ''}}" placeholder="Course">
                                            </div>
                                            <div class="col-md-2 p-0">
                                                <input type="text" class="form-control" name="vocyear" id="vocyear" value="{{$info->vocational_year ?? ''}}" placeholder="Year Graduated" onkeyup="NumbersOnly(this)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="LSA" hidden>
                                        <label class="form-label">Last School Attended:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="lastschool" name="lastschool" placeholder="Name Of School">
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" id="coursetaken" name="coursetaken" placeholder="Course Taken">
                                            </div>
                                            <div class="col-md-2 p-0">
                                                <input type="text" class="form-control" name="lastattend" id="lastattend" placeholder="Last attended" onkeyup="NumbersOnly(this)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Honors/Award received</label>
                                        <input type="text" name="honors" id="honors" value="{{$info->honors ?? ''}}" class="form-control">
                                    </div>
                                    <div class="col-md-12" style="margin: 30px 0 10px 0; ">
                                        <label class="form-label" style="margin-right: 30px">Are you enrolling as a scholar?</label>
                                        <label for="yes-scholar" class="form-check-label" style="margin-right: 30px">
                                            <input type="radio" name="scholar" checked hidden value="None">
                                            <input type="radio" class="form-check-input" id="yes-scholar" name="scholar"
                                                onchange="Scholar()"> Yes
                                        </label>
                                        <label for="no-scholar" class="form-check-label">
                                            <input type="radio" class="form-check-input" name="scholar" value="No" id="no-scholar"
                                                onchange="Scholar()"> No
                                        </label>
                                        <div style="float: right;">
                                            <label>If yes, what scholarship grant?</label>
                                            <input id="scholar-text" type="text" name="scholar" disabled>
                                        </div>
                                    </div>
                                    
                                        <div hidden class="col-12">
                                            <label class="form-label">What course are you enrolled?</label>
                                            <div class="row">
                                                <div class="col-8">
                                                    <select name="gctccourse" class="form-control col-form-label">
                                                        <option value="0">example</option>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" name="gctcyear" onkeyup="NumbersOnly(this)"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    <div class="col-md-12" id="course-sec">
                                        <label class="form-label">Which campus would you enroll</label>
                                        <select name="campus" id="campus" class="form-control col-form-label">
                                            @foreach($campus as $camp)
                                                <option @if($info->campus ?? '' == $camp->campus_name) selected @endif value="{{$camp->campus_name}}">{{$camp->campus_name}}</option>
                                            @endforeach
                                        </select>
                                        <label class="form-label">Please select the course you have enrolled</label>
                                        <div class="col-sm-12 p-0">
                                            <div class="input-group">
                                                <span class="input-group-text" style="width: 100px;">1st Choice</span>
                                                <select name="firstcourse" class="form-control col-form-label">
                                                    @foreach($program as $prog)
                                                    <option @if($info->course_prio ?? '' == $prog->pid) selected @endif value="{{$prog->pid}}">{{$prog->description}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Why did you decide to take the course you are enrolling?</label>
                                        <input type="text" id="qcourse" name="qcourse" value="{{$info->why_this_course ?? ''}}" class="form-control required" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Is it your own choice to enroll in DOrSU?</label>
                                            <input type="radio" name="decide" checked hidden value="None">
                                        <label style="margin-left: 30px" class="form-check-label">
                                            <input type="radio" class="form-check-input" name="decide" value="Yes" id="yes-decide"
                                                onchange="decideNo()"> Yes
                                        </label>
                                        <label style="margin-left: 30px" class="form-check-label">
                                            <input type="radio" class="form-check-input" name="decide" id="no-decide"
                                                onchange="decideNo()"> No
                                        </label>
                                        <div style="float: right;">
                                            <label>If no, who influenced you?
                                            </label>
                                            <input name="decide" id="influenced" type="text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Why did you decide to enroll in DOrSU?</label>
                                        <input type="text" id="qenroll" name="qenroll" value="{{$info->why_this_course ?? ''}}" class="form-control required" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label>What is your plan or ambition in life?</label>
                                        <input type="text" id="qambition" name="qambition" value="{{$info->ambition_in_life ?? ''}}" class="form-control required" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label>What are your Expectations on: </label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" name="expectschool" value="{{$info->school_expectation ?? ''}}" class="form-control required"
                                                    placeholder="School" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="expectinstructor" value="{{$info->instructor_expectation ?? ''}}" class="form-control required"
                                                placeholder="Instructor" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="expectsubjectleast" value="{{$info->subject_like ?? ''}}" class="form-control required"
                                                placeholder="Subject you like least" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="expectcourse" value="{{$info->course_expectation ?? ''}}" class="form-control required"
                                                    placeholder="Course" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="expectstudent" class="form-control required" value="{{$info->student_expectation ?? ''}}"
                                                    placeholder="Students" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="expectsubjectmost" class="form-control required" value="{{$info->subject_most_like ?? ''}}"
                                                placeholder="Subject you like most" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 30px;">
                                        <label class="form-label">Do you have a SCAST Result?</label>
                                        <label style="margin-left: 30px" for="yes" class="form-check-label">
                                            <input type="radio" name="optradioyes" checked hidden value="None">
                                            <input type="radio" class="form-check-input" name="optradioyes" id="yes"
                                                onchange="chooseYes()"> Yes
                                        </label>
                                        <label style="margin-left: 30px" for="no" class="form-check-label">
                                            <input type="radio" class="form-check-input" name="optradioyes" id="no"
                                                onchange="chooseNo()"> No
                                        </label>
                                    </div>
                                    <div id="SCAST" hidden class="col-md-12">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-text" style="width: 300px;">General Ability</span>
                                                    <input type="text" name="genability" value="{{$info->gen_ability ?? ''}}" class="form-control">
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-text" style="width: 300px;">Spatial Aptitude</span>
                                                    <input type="text" name="spatial" value="{{$info->spatial_apt ?? ''}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-text" style="width: 300px;">Verbal Aptitude</span>
                                                    <input type="text" name="verbal" class="form-control" value="{{$info->verbal_apt ?? ''}}">
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-text" style="width: 300px;">Perceptual Aptitude</span>
                                                    <input type="text" name="perceptual" class="form-control" value="{{$info->perceptual_apt ?? ''}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-text" style="width: 300px;">Numerical Aptitude</span>
                                                    <input type="text" name="numerical" class="form-control" value="{{$info->numerical_apt ?? ''}}">
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-text" style="width: 300px;">Manual Dexterity</span>
                                                    <input type="text" name="manual" class="form-control" value="{{$info->manual_dex ?? ''}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" style="margin-top: 20px;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Hobbies/Recreational Activities:</label>
                                                <input type="text" name="hobbies" value="{{$info->hobbies ?? ''}}" class="form-control required">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Motto:</label>
                                                <input type="text" name="motto" value="{{$info->motto ?? ''}}" class="form-control required">
                                            </div>
                                            <div class="col-md-6" style="margin-bottom: 20px;">
                                                <label>Special Skills/Talents:</label>
                                                <input type="text" name="talent" value="{{$info->talent ?? ''}}" class="form-control required">
                                            </div>
                                            <div class="col-md-6" style="margin-bottom: 20px;">
                                                <label>Special Interests:</label>
                                                <input type="text" name="interest" value="{{$info->interest ?? ''}}" class="form-control required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-header col-12">
                                        <h1 style="text-align: center; margin: 20px 0 20px 0; font-family: CENTURY GOTHIC;"> OTHER
                                            INFORMATION</h1>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-check-label pl-0">Are you a person with disability (PWD)?</label>
                                        <label style="margin-left: 30px"><input type="radio" class="form-check-input" onclick="disability(1)" name="pwd" id="pwd-yes"> Yes</label>
                                        <label style="margin-left: 30px"><input type="radio" class="form-check-input" name="pwd" value="No" onclick="disability(0)" id="pwd-no"> No</label>
                                        <label style="float:right">If yes, give details (type of disability): <input type="text" name="pwd" class="form-control" disabled id="pwd-text"></label>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-check-label pl-0">Are you a single parent?</label>
                                        <label style="margin-left: 30px"><input type="radio" class="form-check-input" onclick="parent(1)" name="sparent" id="sp-yes"> Yes</label>
                                        <label style="margin-left: 30px"><input type="radio" class="form-check-input" value="No" onclick="parent(0)" name="sparent" id="sp-no"> No</label>
                                        <label style="float:right">If yes, give details (number of children): <input type="text" name="sparent" class="form-control" disabled id="parent-text"></label>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-check-label pl-0">Are you a working-student?</label>
                                        <label style="margin-left: 30px"><input type="radio" class="form-check-input" onclick="employee(1)" name="wstudent" id="emp-yes"> Yes</label>
                                        <label style="margin-left: 30px"><input type="radio" class="form-check-input" value="No" onclick="employee(0)" name="wstudent" id="emp-no"> No</label>
                                        <label style="float:right">If yes, give details (employer): <input type="text" class="form-control" name="wstudent" disabled id="emp-text"></label>
                                    </div>
                                    <div class="card-header col-12">
                                        <h1 style="text-align: center; margin: 20px 0 20px 0; font-family: CENTURY GOTHIC;"> SELF
                                            ASSESSMENT</h1>
                                    </div>
                                    <div class="col-md-12">
                                        <label>What traits/characteristics do you think you posses? (You may check as many)</label>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="tense/jittery"> tense/jittery
                                            </label>
                                            <input type="hidden" name="81" value="260" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="confident"> confident
                                            </label>
                                            <input type="hidden" name="81" value="274" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="submissive"> submissive
                                            </label>
                                            <input type="hidden" name="81" value="301" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="independent"> independent
                                            </label>
                                            <input type="hidden" name="81" value="315" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="sensitive"> sensitive
                                            </label>
                                            <input type="hidden" name="81" value="329" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="trusting"> trusting
                                            </label>
                                            <input type="hidden" name="81" value="356" class="hdn_assesment">
                                        </div>
                                    </div>
                                    <div class=" col-md-3">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="easily troubled"> easily troubled
                                            </label>
                                            <input type="hidden" name="194" value="260" class="hdn_assesment">
                                        </div>
                                        <div class=" form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="responsible"> responsible
                                            </label>
                                            <input type="hidden" name="194" value="274" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="relaxed/calm"> relaxed/calm
                                            </label>
                                            <input type="hidden" name="194" value="287" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="dependent"> dependent
                                            </label>
                                            <input type="hidden" name="194" value="301" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="perceptive"> perceptive
                                            </label>
                                            <input type="hidden" name="194" value="315" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="insecure"> insecure
                                            </label>
                                            <input type="hidden" name="194" value="329" class="hdn_assesment">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="happy-go-lucky"> happy-go-lucky
                                            </label>
                                            <input type="hidden" name="311" value="260" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]" value="loner">
                                                loner
                                            </label>
                                            <input type="hidden" name="311" value="274" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="suspicious"> suspicious
                                            </label>
                                            <input type="hidden" name="311" value="287" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="stubborn"> stubborn
                                            </label>
                                            <input type="hidden" name="311" value="301" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="idealistic"> idealistic
                                            </label>
                                            <input type="hidden" name="311" value="315" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="worrier"> worrier
                                            </label>
                                            <input type="hidden" name="311" value="329" class="hdn_assesment">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="friendly"> friendly
                                            </label>
                                            <input type="hidden" name="437" value="260" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="imaginative"> imaginative
                                            </label>
                                            <input type="hidden" name="437" value="274" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="dominant"> dominant
                                            </label>
                                            <input type="hidden" name="437" value="287" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="sentimental"> sentimental
                                            </label>
                                            <input type="hidden" name="437" value="301" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]"
                                                    value="practical"> practical
                                            </label>
                                            <input type="hidden" name="437" value="315" class="hdn_assesment">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input selfassesment" name="selfassesment[]" id="otherpossesed"
                                                    onchange="OthersPossesed()"> Others:
                                            </label>
                                            <input type="hidden" name="437" value="329" class="hdn_assesment">
                                        </div>
                                        <input style="float: left;" type="text" class="form-control" id="otherposstext" disabled>
                                    </div>
                                    <div class="col-md-12">
                                        <label>What bothers you most at the moment?</label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" value="Financial difficulty" class="form-check-input bother" name="bothers[]"> Financial difficulty
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" value="Difficulties in adjusting a new school" class="form-check-input bother" name="bothers[]"> Difficulties in
                                                adjusting a new school
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" value="Study habits" class="form-check-input bother" name="bothers[]"> Study habits
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="bothers[]" class="form-check-input bother" id="healthprob"
                                                    onchange="HealthOther()"> Health problems, Please specify:
                                            </label>
                                        </div>
                                        <input style="float: left;" type="text" class="form-control" id="health-text" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input bother" value="Developing self-confidence" name="bothers[]">
                                                Developing self-confidence
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input bother" value="Interpersonal relationship (parent;friends;siblings)" name="bothers[]">
                                                Interpersonal relationship (parent;friends;siblings)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input bother" value="Student-Instructor relationship" name="bothers[]">
                                                Student-Instructor relationship
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input bother" name="bothers[]" id="otherspecify"
                                                    onchange="SpecifyOther()"> Other, please specify:
                                            </label>
                                        </div>
                                        <input style="float: left;" type="text" class="form-control" id="specify-text" disabled>
                                    </div>
                                    <div class="col-md-12">
                                        <label>What was your most embarrassing experience in life?</label>
                                        <input type="text" class="form-control" value="{{$info->embarrassing ?? ''}}" name="embarrassing">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Things you would like to talk and discuss with:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text" style="width: 100px;">Friends</span>
                                            <input type="text" name="friends" value="{{$info->friends ?? ''}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text" style="width: 100px;">Parents</span>
                                            <input type="text" name="parents" value="{{$info->parents ?? ''}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text" style="width: 100px;">Teachers</span>
                                            <input type="text" name="teachers" value="{{$info->teachers ?? ''}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text" style="width: 100px;">Counselors</span>
                                            <input type="text" name="counselors" value="{{$info->counselors ?? ''}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            var bfawork = true, bmowork = true;
            let fawork = "{{$info->fathers_employment ?? ''}}", mowork = "{{$info->mothers_employment ?? ''}}";
            $("input[name='mo-work']").each(function(){
                if($(this).val() == mowork){
                    $(this).attr("checked",true);
                    bmowork = false;
                }
            })
            if(bmowork){
                if(mowork.includes("ofw :")){
                    $("#moofw-radio").val(mowork).attr("checked",true);
                    $("#moofw").val(mowork.replace("ofw :","")).attr("disabled",false);
                }else{
                    $("#moother-radio").val(mowork).attr("checked",true);
                    $("#moother").val(mowork.replace("other :","")).attr("disabled",false);
                }
            }

            $("input[name='fa-work']").each(function(){
                if($(this).val() == fawork){
                    $(this).attr("checked",true);
                    bfawork = false;
                }
            })

            if(bfawork){
                if(fawork.includes("ofw :")){
                    $("#faofw-radio").val(fawork).attr("checked",true);
                    $("#faofw").val(fawork.replace("ofw :","")).attr("disabled",false);
                }else{
                    $("#faother-radio").val(fawork).attr("checked",true);
                    $("#faother").val(fawork.replace("other :","")).attr("disabled",false);
                }
            }

            $("#faofw").keyup(function(){
                $("#faofw-radio").val("ofw :"+$(this).val());
            })
            
            $("#faother").keyup(function(){
                $("#faother-radio").val("other :"+$(this).val());
            })

            $("#moofw").keyup(function(){
                $("#moofw-radio").val("ofw :"+$(this).val());
            })
            
            $("#moother").keyup(function(){
                $("#moother-radio").val("other :"+$(this).val());
            })

            var bother = "{{$info->bothers ?? ''}}";
            console.log(bother);
            if(bother.length > 0){
                bother = bother.replace(/&quot;/g,'"');
                bother = JSON.parse(bother);
                var bbother = true;
                for(var i = 0; i < bother.length ;i++){
                    bbother = true;
                    $("input[name='bothers[]']").each(function(){
                        if($(this).val() == bother[i]){
                            $(this).attr("checked",true);
                            bbother = false;
                        }
                    })
                    if(bbother){
                        if(bother[i].includes("health :")){
                            $("#healthprob").val(bother[i]).attr("checked",true);
                            $("#health-text").val(bother[i].replace("health :","")).attr("disabled",false);
                        }else{
                            $("#otherspecify").val(bother[i]).attr("checked",true);
                            $("#specify-text").val(bother[i].replace("other :","")).attr("disabled",false);
                        }
                    }
                }
            }
            var assesment = "{{$info->selfassesment ?? ''}}";
            if(assesment.length > 0){
                assesment = assesment.replace(/&quot;/g, '"');
                assesment = JSON.parse(assesment);
                for(var i = 0; i < assesment.length ;i++){
                    var bAsses = true;
                    $("input[name='selfassesment[]']").each(function(){
                        if($(this).val() == assesment[i]){
                            $(this).attr("checked",true);
                            bAsses = false;
                        }
                    })
                    if(bAsses){
                        $("#otherpossesed").val(assesment[i]).attr("checked",true);
                        $("#otherposstext").val(assesment[i].replace("other :","")).attr("disabled",false);
                    }
                }
            }
            $("#otherposstext").keyup(function(){
                $("#otherpossesed").val("other :"+$(this).val());
            })

            $("#health-text").keyup(function(){
                $("#healthprob").val("health :"+$(this).val());
            })

            $("#specify-text").keyup(function(){
                $("#otherspecify").val("other :"+$(this).val());
            })
            let ws = "{{$info->working_student ?? ''}}";
            if(ws == "No"){
                $("#emp-no").attr("checked",true);
            }else{
                $("#emp-yes").attr("checked",true);
                $("#emp-text").val(ws).attr("disabled",false);
            }
            let sp = "{{$info->single_parent ?? ''}}";
            if(sp == 'No'){
                $("#sp-no").attr("checked",true);
            }else{
                $("#sp-yes").attr("checked",true);
                $("#parent-text").val(sp).attr("disabled",false);
            }
            let pwd = "{{$info->pwd ?? ''}}";
            if(pwd == 'No'){
                $("#pwd-no").attr("checked",true);
            }else{
                $("#pwd-yes").attr("checked",true);
                $("#pwd-text").val(pwd).attr("disabled",false);
            }
            let decide = "{{$info->decide ?? ''}}";
            if(decide == "Yes"){
                $("#yes-decide").attr("checked",true);
            }else{
                $("#no-decide").attr("checked",true);
                $("#influenced").val(decide).attr("disabled",false);
            }

            let scholar = "{{$info->scholar ?? ''}}";
            if(scholar == "No"){
                $("#no-scholar").attr("checked",true);
            }else{
                $("#yes-scholar").attr("checked",true);
                $("#scholar-text").val(scholar).attr("disabled",false);
            }
            $("input[name='optradio2']").each(function(){
                if($(this).val() == "{{$info->parents_are ?? ''}}"){
                    $(this).attr('checked', true);
                }
            })

            $("#ethnic").val("{{$info->ethnic_group ?? ''}}");
            $("#insertstud").on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: $(this).attr("action"),
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    dataType: 'json',
                    processData: false,
                    success: function(result) {
                        if(result.success){
                            toastr.success(result.msg);
                        }else{
                            toastr.error(result.msg);
                        }
                    }
                })
            })

        })
        
        function NumbersOnly(input) {
            var regex = /[^0-9'"]/g;
            input.value = input.value.replace(regex, "");
        }
    </script>
    <script src="{{ asset('js/enroll.js') }}"></script>
</html>