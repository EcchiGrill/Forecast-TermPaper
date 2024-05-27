<?php
header("Content-type: text/css");


$font_family = 'Arial, Helvetica, sans-serif';
$font_size = '0.7em';
$border = '1px solid';
?>

body {
height: 100vh;
justify-content: center;
display: flex;
align-items: center;
flex-direction: column;
background: #f0f0f0;
font-family: Arial, Helvetica, sans-serif;
}

form {
text-align: center;
}

h1 {
font-size: 50px;
}

label {
font-size: 25px;
}

select {
appearance: none;
padding-left: 15px;
margin-left: 5px;
font-size: 20px;
border: 0;
outline: 0;
font: inherit;
width: 9rem;
height: 2.5rem;
color: gray;
border-radius: 0.25em;
box-shadow: 0 0 1em 0 rgba(0, 0, 0, 0.2);
background: url(https://i.ibb.co/vBd4N5b/list.png)
no-repeat right 0.4em center / 1.4em;
background-size: 15px;
cursor: pointer;
&::-ms-expand {
display: none;
}
&:focus {
outline: none;
}
}

.city_container {
display: flex;
justify-content: center;
align-items: center;
}

.date_container {
display: flex;
justify-content: center;
align-items: center;
margin-top: 15px;
}

.date, input {
width: 9rem;
height: 2.5rem;
appearance: none;
padding-left: 10px;
margin-left: 5px;
font-size: 14px;
border: 0;
outline: 0;
cursor: pointer;
color: gray;
border-radius: 0.25em;
box-shadow: 0 0 1em 0 rgba(0, 0, 0, 0.2);
background: #f0f0f0;
}

.submit {
width: 160px;
height: 40px;
font-size: 16px;
margin-top: 18px;
border-radius: 3px;
box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
color: #ffff;
background: #66696f;
border: none;
cursor: pointer
}

.weather_container {
display: flex;
flex-direction: column;
align-items: center;
}

.weather_block {
display: flex;
flex-direction: column;
align-items: center;
margin-bottom: 20px;
}

.forecast_container {
display: flex;
width: 520px;
height: 300px;
background: #dfdfdf;
box-shadow: rgba(0, 0, 0, 0.20) 0px 54px 55px, rgba(0, 0, 0, 0.04) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px,
rgba(0, 0, 0, 0.05) 0px 12px 13px, rgba(0, 0, 0, 0.08) 0px -3px 5px;
align-items: center;
justify-content: center;
border-radius: 8px;
}

.forecast_date {
text-align: center;
font-size: 35px;
line-height: 1.4;
}

.forecast_text {
display: flex;
flex-direction: column;
text-align: center;
margin-left: 90px;
line-height: 1.3;
font-size: 17px;
color: #4a4f5d;
}