<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Test</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    </head>
    <body style="background-color:#EBEDF3">
        <div style="height:80px"></div>
        <div class="text-center"><img src="{{url('/images/energeek_logo.png')}}" alt="energeek_logo"  style="width:250.8px; height:60px;"/></div>
        <div style="height:30px"></div>
        
        <div class="card m-auto" style="width: 530px;">
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
                    <input type="text" class="form-control" id="position" aria-describedby="position" placeholder="Pilih Jabatan">
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
                        <option value="1">PHP</option>
                        <option value="2">Laravel</option>
                        <option value="3">Vue</option>
                    </select>
                    <!-- <input type="text" class="form-control" id="skills" aria-describedby="skills" placeholder="Pilih Skill"> -->
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div style="height:30px"></div>
                <button class="btn btn-danger w-100" disabled>Apply</button>
                <div style="height:30px"></div>
            </div>
        </div>


        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            function initDatePicker() {
                $("#birthYear").datepicker({
                    format: "yyyy",
                    viewMode: "years", 
                    minViewMode: "years"
                });
            }

            function initSlect2MultipleWithID(elementID, placeholder) {
                $('#'+elementID).select2({
                    theme: "bootstrap-5",
                    placeholder: placeholder,
                    closeOnSelect: false,
                    multiple: true,
                });
            }

            $(document).ready(function(){
                initDatePicker()
                initSlect2MultipleWithID('skills', 'Pilih Skill')
            })
            
        </script>
    </body>
</html>