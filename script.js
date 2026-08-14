const users = {
    D001: {
        password: "1234",
        name: "Dr. Rahul",
        role: "Doctor",
        dashboard: "doctor_dashboard.html"
    },

    N001: {
        password: "1234",
        name: "Anita Sharma",
        role: "Nurse",
        dashboard: "nurse_dashboard.html"
    }
};


// LOGIN
function validateLogin() {

    const inputs = document.querySelectorAll("input");
    const userType = document.querySelector("select");

    const employeeId = inputs[0].value.trim();
    const password = inputs[1].value;

    const user = users[employeeId];

    if (!user || user.password !== password) {
        alert("Invalid Employee ID or Password.");
        return false;
    }

    if (
        userType.value !== "Select User" &&
        userType.value !== "" &&
        userType.value !== user.role
    ) {
        alert("Please select the correct user type.");
        return false;
    }

    localStorage.setItem("employeeId", employeeId);
    localStorage.setItem("employeeName", user.name);
    localStorage.setItem("role", user.role);

    window.location.href = user.dashboard;

    return false;
}


// MARK ATTENDANCE
function markAttendance() {

    const employeeId = localStorage.getItem("employeeId");
    const employeeName = localStorage.getItem("employeeName");

    const shiftElement = document.getElementById("shift");

    if (!employeeId) {
        window.location.href = "login.html";
        return;
    }

    if (!shiftElement || shiftElement.value === "") {
        alert("Please select a shift.");
        return;
    }

    let records =
        JSON.parse(localStorage.getItem("attendanceRecords")) || [];

    const date = new Date().toLocaleDateString("en-IN");

    records.push({
        employeeId: employeeId,
        name: employeeName,
        date: date,
        shift: shiftElement.value,
        status: "Present"
    });

    localStorage.setItem(
        "attendanceRecords",
        JSON.stringify(records)
    );

    alert("Attendance marked successfully!");

    window.location.href = "attendance_history.html";
}


// LOGOUT
function logout() {

    localStorage.removeItem("employeeId");
    localStorage.removeItem("employeeName");
    localStorage.removeItem("role");

    window.location.href = "login.html";
}