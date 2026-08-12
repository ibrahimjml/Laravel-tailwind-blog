document.addEventListener("DOMContentLoaded", function () {
    const phoneInputField = document.querySelector("#phone");

    // Initialize intl-tel-input
    const phoneInput = window.intlTelInput(phoneInputField, {
        utilsScript:
            "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    fetch("https://get.geojs.io/v1/ip/geo.json")
        .then((response) => response.json())
        .then((data) => {
            const country = data.country_code; // Country code like "US", "IN", etc.
            phoneInput.setCountry(country); // Set the country
        })
        .catch((error) => console.error("Error fetching location:", error));
    const form = document.querySelector("#phone-form");
    form.addEventListener("submit", function (eo) {
        eo.preventDefault();

        const countryCode = phoneInput.getSelectedCountryData().dialCode;
        const phoneNumber = phoneInput.getNumber();

        const countryCodeInput = document.createElement("input");
        countryCodeInput.type = "hidden";
        countryCodeInput.name = "country_code";
        countryCodeInput.value = countryCode;
        form.appendChild(countryCodeInput);

        phoneInputField.value = phoneNumber;

        form.submit();
    });
});
