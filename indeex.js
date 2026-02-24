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






function openTab(tabId) {
  // Hide all contents
  const contents = document.querySelectorAll('.content');
  contents.forEach(content => content.classList.remove('active'));

  // Remove active from tabs
  const tabs = document.querySelectorAll('.tab');
  tabs.forEach(tab => tab.classList.remove('active'));

  // Show selected content
  document.getElementById(tabId).classList.add('active');

  // Activate clicked tab
  event.target.classList.add('active');
}





const params = new URLSearchParams(window.location.search);
const selectedPrice = params.get("price");

if (selectedPrice) {
  document.querySelectorAll(".price-box").forEach(box => {
    if (box.getAttribute("href").includes(selectedPrice)) {
      box.classList.add("active");
      document.getElementById("result").innerText =
        "Selected Price Range: " + box.innerText;
    }
  });
}







function openBike(bikeKey) {
  document.getElementById("bikeName").innerText = bikes[bikeKey].name;
  const specList = document.getElementById("bikeSpecs");
  specList.innerHTML = "";

  bikes[bikeKey].specs.forEach(spec => {
    const li = document.createElement("li");
    li.innerText = spec;
    specList.appendChild(li);
  });

  document.getElementById("bikeModal").style.display = "block";
}

function closeModal() {
  document.getElementById("bikeModal").style.display = "none";
}



document.querySelectorAll(".pc-card").forEach(card => {
  card.addEventListener("click", () => {
    window.location.href = card.getAttribute("href");
  });
});





