//error message if username is taken
function username_validation() {
    const element = document.createElement("p");
    element.innerHTML = "A user with this username already exists. <br>Please try again."
    element.style.color = "red";
    element.style.fontSize = "15px"
    element.style.textAlign = "center"
    document.getElementById("register").appendChild(element);
}

//error message if email has already been used
function email_validation() {
    const element = document.createElement("p");
    element.innerHTML = "A user with this email already exists. <br>Please try again."
    element.style.color = "red";
    element.style.fontSize = "15px"
    element.style.textAlign = "center"
    document.getElementById("register").appendChild(element);
}

//message after successful login
function login_success() {
    const form = document.getElementById("login")
    form.style.display = "none"
    const p = document.getElementById("register")
    p.style.display = "none"
    const nav = document.getElementById("nav")
    nav.style.display = "none"
    const element = document.createElement("h2");
    element.innerHTML = "Login successful. Redirecting to main page."
    document.getElementById("login_logout").innerHTML = "Logout"
    document.getElementById("form-container").appendChild(element);
    setTimeout(() => {
        window.location.replace("index.php");
      }, 2000);
}

//error message in case of failed login
function login_error() {
    const element = document.createElement("p");
    element.innerHTML = "Wrong username or password. <br>Please try again."
    element.style.color = "red";
    element.style.fontSize = "15px"
    element.style.textAlign = "center"
    document.getElementById("login").appendChild(element);
}

//error message in case property has been booked for the selected dates
function date_error() {
    const element = document.createElement("p");
    element.innerHTML = "<br>The property is unavailable during these dates. <br>Please try different dates."
    element.style.color = "red";
    element.style.fontSize = "15px"
    element.style.textAlign = "center"
    document.getElementById("booking-form").appendChild(element);
}

//message after successful booking of property
function booking_success() {
    const form = document.getElementById("booking-form")
    form.style.display = "none"
    const nav = document.getElementById("nav")
    nav.style.display = "none"
    const element = document.createElement("h2");
    element.innerHTML = "Booking succesful. Thanks for your patronage."
    document.getElementById("booking").appendChild(element);
    setTimeout(() => {
        window.location.replace("index.php");
      }, 3500);
}

//shows the total price for the selected dates
function price_calculator(total_price) {
    const element = document.createElement("p");
    element.innerHTML = "The total price for the selected dates is: <br>" + total_price;
    element.style.fontSize = "25px"
    element.style.textAlign = "center"
    document.getElementById("booking-form").appendChild(element)
}

//validates if fields are correctly filled out
function listing_field_validation() {
    //check if fields are filled out correctly
    const title = document.getElementById('title');
    const location = document.getElementById('location');

    title.addEventListener('keyup', function() {
        const title = this.value;
        const errorMessage = document.getElementById('title-error');
        const regex = /^[a-zA-Z\s]*$/;

        if (regex.test(title)) {
            errorMessage.style.display = 'none';
        } else {
            errorMessage.style.display = 'block';
        }
    });

    location.addEventListener('keyup', function() {
        const location = this.value;
        const errorMessage = document.getElementById('location-error');
        const regex = /^[a-zA-Z\s]*$/;

        if (regex.test(location)) {
            errorMessage.style.display = 'none';
        } else {
            errorMessage.style.display = 'block';
        }
    });
    //rooms and price are checked through HTML
}

//message after succesfully listing property
function listing_creation() {
    const form = document.getElementById("create-listing")
    form.style.display = "none"
    const nav = document.getElementById("nav")
    nav.style.display = "none"
    const element = document.createElement("h2");
    element.innerHTML = "Succesfully listed your property."
    document.getElementById("create").appendChild(element);
    setTimeout(() => {
        window.location.replace("index.php");
      }, 2000);
}