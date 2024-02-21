<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Test</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <style>
            body {
                font-family: "Poppins", sans-serif;
            }
        </style>
    </head>
    <body style="background-color:#EBEDF3">
        <div style="height:80px"></div>
        <div class="text-center"><img src="{{url('/images/energeek_logo.png')}}" alt="energeek_logo"  style="width:250.8px; height:60px;"/></div>
        <div style="height:30px"></div>
        
        <div class="card m-auto" style="width: 530px; border-radius: 12px;">
            <div class="card-body">
                <p style="font-size:24px; font-weight:500; text-align:center;">Apply Lamaran</p>
                <div class="form-group">
                    <label for="fullName">Nama Lengkap</label>
                    <div style="height:10px"></div>
                    <input type="text" class="form-control" id="fullName" aria-describedby="fullName" placeholder="Jamal Subagyo">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div style="height:30px"></div>
                <div class="form-group">
                    <label for="position">Jabatan</label>
                    <div style="height:10px"></div>
                    <select class="form-select select2-single" id="position" name="position" data-placeholder="Pilih Jabatan">
                        @foreach ($jobs as $job)
                            <option value="{{$job->id}}">{{$job->name}}</option>
                        @endforeach
                    </select>
                    {{-- <input type="text" class="form-control" id="position" aria-describedby="position" placeholder="Pilih Jabatan"> --}}
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div style="height:30px"></div>
                <div class="form-group">
                    <label for="phone">Telepon</label>
                    <div style="height:10px"></div>
                    <input type="text" class="form-control" id="phone" aria-describedby="phone" placeholder="Cth: 0893239851289">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div style="height:30px"></div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <div style="height:10px"></div>
                    <input type="email" class="form-control" id="email" aria-describedby="email" placeholder="Cth: energeekmail@gmail.com">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div style="height:30px"></div>
                <div class="form-group">
                    <label for="birthYear">Tahun Lahir</label>
                    <div style="height:10px"></div>
                    <input type="text" class="form-control" id="birthYear" aria-describedby="birthYear" placeholder="Pilih Tahun">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div style="height:30px"></div>
                <div class="form-group">
                    <label for="skills">Skill Set</label>
                    <div style="height:10px"></div>
                    <select class="form-select select2-multiple" id="skills" name="skills[]" data-placeholder="Pilih Skill" multiple>
                        @foreach ($skills as $skill)
                            <option value="{{$skill->id}}">{{$skill->name}}</option>
                        @endforeach
                    </select>
                    <!-- <input type="text" class="form-control" id="skills" aria-describedby="skills" placeholder="Pilih Skill"> -->
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div style="height:30px"></div>
                <button class="btn btn-danger w-100" onclick="saveCandidate()">Apply</button>
                <div style="height:30px"></div>
            </div>
        </div>


        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            function initDatePicker() {
                $("#birthYear").datepicker({
                    format: "yyyy",
                    viewMode: "years", 
                    minViewMode: "years"
                });
            }

            function resetSelect2(elementID) {
                $("#"+elementID).val('').trigger('change');
            }

            function initSlect2MultipleWithID(elementID, placeholder) {
                $('#'+elementID).select2({
                    theme: "bootstrap-5",
                    placeholder: placeholder,
                    closeOnSelect: false,
                    multiple: true,
                });
            }

            function initSlect2WithID(elementID, placeholder) {
                $('#'+elementID).select2({
                    theme: "bootstrap-5",
                    placeholder: placeholder,
                });
            }

            $(document).ready(function(){
                initDatePicker()
                initSlect2MultipleWithID('skills', 'Pilih Skill')
                initSlect2WithID('position', 'Pilih Jabatan')
                resetSelect2('position')
            })

            function maybeValidEmail (email) { return /^\S+@\S+\.\S+$/.test(email); }
            function isNumeric(str) {
                if (typeof str != "string") return false // we only process strings!  
                return !isNaN(str) && // use type coercion to parse the _entirety_ of the string (`parseFloat` alone does not do this)...
                        !isNaN(parseFloat(str)) // ...and ensure strings of whitespace fail
            }

            function quickCheck(fullName,position,phone,email,birthYear,skills) {
                let listError = []
                if (fullName == null || fullName == "" || fullName == undefined) {
                    listError.push("Full Name is Required")
                }

                if (position == null || position == "" || position == undefined) {
                    listError.push("position is Required")
                }

                if (phone == null || phone == "" || phone == undefined) {
                    listError.push("phone is Required")
                }

                if (!isNumeric(phone)) {
                    listError.push("phone is Invalid")
                }


                if (email == null || email == "" || email == undefined) {
                    listError.push("email is Required")
                }

                if (!maybeValidEmail(email)) {
                    listError.push("email is Invalid")
                }

                if (birthYear == null || birthYear == "" || birthYear == undefined) {
                    listError.push("Birth Year is Required")
                }

                if (!isNumeric(birthYear)) {
                    listError.push("Birth Year is Required")
                }

                birthYear = parseInt(birthYear)
                if (birthYear < 1970 || birthYear > 2024) {
                    listError.push("Birth Year is Invalid")
                }

                if (skills.length == 0) {
                    listError.push("skills is Required")
                }

                if (listError.length != 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "Terjadi Kesalahan!",
                        text: listError.toString(),
                        confirmButtonColor: "#F64E60",
                        confirmButtonText: "Baiklah",
                    });
                    return false
                }
                return true
            }

            async function saveCandidate() {
                let fullName = $('#fullName').val()
                let position = $('#position').val()
                let phone = $('#phone').val()
                let email = $('#email').val()
                let birthYear = $('#birthYear').val()
                let skills = $('#skills').val()
                if(!quickCheck(fullName,position,phone,email,birthYear,skills)){
                    return
                }

                let payload = {
                    full_name:fullName,
                    position:position,
                    phone:phone,
                    email:email,
                    birth_year:birthYear,
                    skills:skills
                }

                try {
                    let apiURL = 'http://127.0.0.1:8000/api/v1/new-candidate'
                    const response = await axios.post(apiURL,payload);
                    let fullName = $('#fullName').val("")
                    resetSelect2('position')
                    let phone = $('#phone').val("")
                    let email = $('#email').val("")
                    let birthYear = $('#birthYear').val("")
                    resetSelect2('skills')
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Lamaran berhasil dikirim.",
                        icon: "success",
                        confirmButtonColor: "#1BC5BD",
                        confirmButtonText: "Selesai!",
                    });
                } catch (error) {
                    let listError = [];
                    for (const element in error.response.data.error) {
                        listError.push(error.response.data.error[element])
                    }
                    Swal.fire({
                        icon: "warning",
                        title: "Terjadi Kesalahan!",
                        text: listError.toString(),
                        confirmButtonColor: "#F64E60",
                        confirmButtonText: "Baiklah",
                    });
                    return false
                }
            }
            
        </script>
    </body>
</html>