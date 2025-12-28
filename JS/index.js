document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.main-menu ul li');

    menuItems.forEach(item => {
        item.addEventListener('hover', function() {
            const active = document.querySelector('.main-menu ul li.active');
            if(active && active !== item) {
                active.classList.remove('active');
                const submenu = active.querySelector('ul');
                if(submenu) submenu.style.display = 'none';
            }

            item.classList.toggle('active');
            const submenu = item.querySelector('ul');
            if(submenu) {
                if(submenu.style.display === 'block') {
                    submenu.style.display = 'none';
                } else {
                    submenu.style.display = 'block';
                }
            }
        });
    });
});


const navButtons = document.querySelectorAll(".nav-button");

navButtons.forEach(btn => {
    btn.addEventListener("click", () => {
        navButtons.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");
    });
});


document.querySelectorAll(".dropdown-wrapper > span").forEach(btn => {
    btn.addEventListener("click", e => {
        e.stopPropagation();
        const dropdown = btn.nextElementSibling;

        document.querySelectorAll(".action-dropdown").forEach(d => {
            if (d !== dropdown) d.classList.remove("show");
        });

        dropdown.classList.toggle("show");
    });
});

document.querySelectorAll(".action-dropdown li").forEach(item => {
    item.addEventListener("click", e => {
        e.stopPropagation();
        const wrapper = item.closest(".dropdown-wrapper");
        const btn = wrapper.querySelector("span");

        btn.textContent = item.textContent + " ▾";
        wrapper.querySelector(".action-dropdown").classList.remove("show");
    });
});

document.addEventListener("click", () => {
    document.querySelectorAll(".action-dropdown")
        .forEach(d => d.classList.remove("show"));
});


// const translations = {
//     en: {
//         bikes: "BIKES",
//         scooters: "SCOOTERS",
//         login: "Login /",
//         register:"Register",
//         usedbikes:"Used Bikes",
//         comparebike:"Compare Bikes",
//         review:"Community & Review"
        
//     },
//     np: {
//         bikes: "मोटरसाइकल",
//         scooters: "स्कुटर",
//         login: "लगइन /",
//         register:"दर्ता",
//         usedbikes:"प्रयोग भएको बाइक",
//         comparebike:"बाइक तुलना ",
//         review:"समुदाय र समीक्षा"
        
//     }
// };


// function translatePage(lang) {
//     document.querySelectorAll("[data-i18n]").forEach(el => {
//         const key = el.getAttribute("data-i18n");
//         el.textContent = translations[lang][key];
//     });

//     localStorage.setItem("language", lang);
// }


document.querySelectorAll(".action-dropdown li").forEach(item => {
    item.addEventListener("click", e => {
        e.stopPropagation();
        const selectedLang = item.textContent.toLowerCase();

        if (selectedLang === "नेपाली") translatePage("np");
        else translatePage("en");

        const btn = item.closest(".dropdown-wrapper").querySelector("span");
        btn.textContent = item.textContent + " ▾";
    });
});



const savedLang = localStorage.getItem("language") || "en";
translatePage(savedLang);


let bikeType = "new";
let filterType = "brand";

function selectNew() {
    bikeType = "new";
    document.getElementById("newBtn").classList.add("active");
    document.getElementById("usedBtn").classList.remove("active");
    showCorrectSection();
}

function selectUsed() {
    bikeType = "used";
    document.getElementById("usedBtn").classList.add("active");
    document.getElementById("newBtn").classList.remove("active");
    showCorrectSection();
}

function showBrand() {
    filterType = "brand";
    showCorrectSection();
}

function showBudget() {
    filterType = "budget";
    showCorrectSection();
}

function showCorrectSection() {
    const sections = ["newBrand", "newBudget", "usedBrand", "usedBudget"];
    sections.forEach(id => document.getElementById(id).style.display = "none");

    if (bikeType === "new" && filterType === "brand") {
        document.getElementById("newBrand").style.display = "block";
    }
    if (bikeType === "new" && filterType === "budget") {
        document.getElementById("newBudget").style.display = "block";
    }
    if (bikeType === "used" && filterType === "brand") {
        document.getElementById("usedBrand").style.display = "block";
    }
    if (bikeType === "used" && filterType === "budget") {
        document.getElementById("usedBudget").style.display = "block";
    }
}

function loadModels() {
    const brand = document.getElementById("brand").value;
    const model = document.getElementById("model");

    const models = {
        Honda: ["Shine", "Hornet", "Unicorn"],
        Yamaha: ["FZ", "R15", "MT-15"],
        Bajaj: ["Pulsar", "Dominar", "Platina"]
    };

    model.innerHTML = "<option>Select Model</option>";

    models[brand].forEach(m => {
        let opt = document.createElement("option");
        opt.text = m;
        model.add(opt);
    });
}



function showTab(tabId) {
    // Tabs
    document.querySelectorAll(".tab").forEach(tab => tab.classList.remove("active"));
    event.target.classList.add("active");

    // Contents
    document.querySelectorAll(".tab-content").forEach(c => c.classList.add("hidden"));
    document.getElementById(tabId).classList.remove("hidden");
}

// Budget selection
document.querySelectorAll(".budget-btn").forEach(btn => {
    btn.addEventListener("click", function () {
        document.querySelectorAll(".budget-btn").forEach(b => b.classList.remove("active"));
        this.classList.add("active");

        // You can redirect or filter here
        console.log("Selected Budget:", this.innerText);
    });
});




