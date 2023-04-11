<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Label Floating Test</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
  {{-- <link rel="stylesheet" type="text/css" href="/css/bootstrap-float-label.min.css"> --}}
  <style type="text/css">
  .has-float-label {
  display: block;
  position: relative;
}

.has-float-label label,
.has-float-label>span {
  color: grey;
  position: absolute;
  left: 0;
  top: 0;
  cursor: text;
  font-size: 120%;
  opacity: 1;
  -webkit-transition: all .3s;
  transition: all .3s;
}

.has-float-label select {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
}

.has-float-label textarea {
  width: 100%;
}

.has-float-label input,
.has-float-label select,
.has-float-label textarea {
  font-size: 15px;
  font-weight: normal !important;
  padding-top: 1.3em;
  margin-bottom: 2px;
  border: 0;
  height: 45px;
  border-radius: 0;
  border-bottom: 2px solid rgba(0, 0, 0, .1);
}

.has-float-label input::-webkit-input-placeholder,
.has-float-label select::-webkit-input-placeholder,
.has-float-label textarea::-webkit-input-placeholder {
  opacity: 1;
  -webkit-transition: all .2s;
  transition: all .2s;
}

.has-float-label input::-moz-placeholder,
.has-float-label select::-moz-placeholder,
.has-float-label textarea::-moz-placeholder {
  opacity: 1;
  transition: all .2s;
}

.has-float-label input:-ms-input-placeholder,
.has-float-label select:-ms-input-placeholder,
.has-float-label textarea:-ms-input-placeholder {
  opacity: 1;
  transition: all .2s;
}

.has-float-label input::placeholder,
.has-float-label select::placeholder,
.has-float-label textarea::placeholder {
  opacity: 1;
  -webkit-transition: all .2s;
  transition: all .2s;
}

.has-float-label input:invalid:not(:focus)::-webkit-input-placeholder {
  opacity: 0;
}

.has-float-label input:invalid:not(:focus)::-moz-placeholder {
  opacity: 0;
}

.has-float-label input:focus:-ms-input-placeholder {
  opacity: 0;
}

.has-float-label input:invalid:not(:focus):-ms-input-placeholder {
  color:transparent;
}

.has-float-label input:placeholder-shown:not(:focus)::placeholder,
.has-float-label select:placeholder-shown:not(:focus)::placeholder,
.has-float-label textarea:placeholder-shown:not(:focus)::placeholder {
  opacity: 0;
}

.has-float-label input:invalid:not(:focus)+*,
.has-float-label select:invalid:not(:focus)+*,
.has-float-label textarea:invalid:not(:focus)+* {
  font-size: 140%;
  opacity: .5;
  top: 1.3em;
}

.has-float-label input:focus,
.has-float-label select:focus,
.has-float-label textarea:focus {
  outline: 0;
  border-color: #4285f4;
}

.has-float-label select {
  padding-right: 1em;
  background: url("data:image/svg+xml);
 charset=utf8, %3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23333' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E") no-repeat right .5em bottom .25em;
 background-size: 8px 10px;
}
  </style>
</head>
<body>
  <div class="container">
    <div class="col-md-6 col-md-offset-3">
      <br>
      <form action="" method="POST">
        <div class="fNameSection_class col-sm-6">
          <div class="formatting ">
            <div class="has-float-label">
                <input type = "text" id="first_name" name="fname" placeholder="" required="required"/>
                <label> FIRST NAME</label>
              </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  
</body>
</html>