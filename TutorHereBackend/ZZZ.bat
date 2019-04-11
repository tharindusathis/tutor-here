::php artisan code:models --table=learner   
::php artisan code:models --table=learnerlocation   
::php artisan code:models --table=payment   
::php artisan code:models --table=qualification   
::php artisan code:models --table=request   
::php artisan code:models --table=review   
::php artisan code:models --table=singletimeslot   
::php artisan code:models --table=subject   
::php artisan code:models --table=tuition   
::php artisan code:models --table=tutor    
::php artisan code:models --table=tutorlocation   
::php artisan code:models --table=weeklytimeslot  

php artisan make:controller LearnerController --resource --model=Models/Learner   
php artisan make:controller LearnerlocationController --resource --model=Models/Learnerlocation
php artisan make:controller PaymentController --resource --model=Models/Payment   
php artisan make:controller QualificationController --resource --model=Models/Qualification   
php artisan make:controller RequestController --resource --model=Models/Request   
php artisan make:controller ReviewController --resource --model=Models/Review   
php artisan make:controller SingletimeslotController --resource --model=Models/Singletimeslot  
php artisan make:controller SubjectController --resource --model=Models/Subject   
php artisan make:controller TuitionController --resource --model=Models/Tuition   
::php artisan make:controller TutorController --resource --model=Models/Tutor    
php artisan make:controller TutorlocationController --resource --model=Models/Tutorlocation   
php artisan make:controller WeeklytimeslotController --resource --model=Models/Weeklytimeslot  

pause