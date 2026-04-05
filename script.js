const button1=document.getElementById('mybutton1');
button1.addEventListener('click',function(){
    window.location.href='patient/patient_login.php';
});

document.querySelectorAll('.symptom-checker').forEach(btn => {
    btn.addEventListener('click', () => {
        window.location.href = 'patient/patient_registration.php';
    });
});
document.querySelectorAll('.health-tips').forEach(btn => {
    btn.addEventListener('click', () => {
        window.location.href = 'health_tips.html';
    });
});
document.querySelectorAll('.bmi').forEach(btn => {
    btn.addEventListener('click', () => {
        window.location.href = 'BMI_calculator.html';
    });
});

