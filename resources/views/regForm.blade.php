<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    @vite('resources/css/regForm.css')
</head>
<body>
    <main>
        <form action="{{ route('register.store') }}" id="registration-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="left-part">
                <h2>Registration</h2>
                <div class="user-profile">
                    <img id="user-image" src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="User Image" name="userImage">
                    <input type="file" name="user_image" id="user_image_input" accept="image/*" style="display: none;">
                    <button id="choose-photo">Choose Profile Photo</button>
                </div>
            </div>

            <div class="right-part">
                <div class="name container">
                    <div class="box">
                        <label for="fname">Full Name</label>
                        <input type="text" class="form-input" id="fname" name="full_name" placeholder="Full Name">
                    </div>

                    <div class="box">
                        <label for="uName">Username</label>
                        <input type="text" class="form-input" id="uName" name="user_name" placeholder="Username">
                    </div>
                </div>

                <div class="telephone container">
                    <div class="box">
                        <label for="phone">
                            Phone Number 
                            <!-- <i 
                                class="fa-solid fa-circle-question" 
                                title="phone number should start with country code then the phone number. ex: 201096132270">
                            </i> -->
                        </label>
                        <input type="tel" class="form-input" id="phone" name="phone_number" placeholder="Phone Number">
                    </div>

                    <div class="box">
                        <label for="whatsAppNumber">
                            WhatsApp Phone Number 
                            <i 
                                class="fa-solid fa-circle-question" 
                                title="whatsapp number should start with country code then the phone number. ex: 201096132270">
                            </i>
                        </label>
                        <input type="tel" class="form-input" id="whatsAppNumber" name="whatsapp_number" placeholder="WhatsApp Number">
                    </div>
                </div>

                <div class="pass-conPass container">
                    <div class="box">
                        <label for="password">Password</label>
                        <input type="password" class="form-input" id="password" name="user_password" placeholder="Password">
                    </div>

                    <div class="box">
                        <label for="cPassword">Confirm Password</label>
                        <input type="password" class="form-input" id="cPassword" placeholder="Confirm Password" disabled>
                    </div>
                </div>

                <div class="email-address container">
                    <div class="box">
                        <label for="address">Address</label>
                        <input type="text" class="form-input" id="address" name="user_address" placeholder="Address">
                    </div>

                    <div class="box">
                        <label for="email">Email</label>
                        <input type="email" class="form-input" id="email" name="user_email" placeholder="E-mail">
                    </div>
                </div>
            </div>

            <input class="submit-form" type="submit" value="Register">
        </form>
    </main>
    @vite(['resources/js/regForm.js', 'resources/js/validation.js'])
</body>
</html>