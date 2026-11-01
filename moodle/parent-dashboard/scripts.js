document.addEventListener("DOMContentLoaded", function () {
    const studentLinks = document.querySelectorAll(".student-link");
    const studentInfo = document.querySelector(".student-info");

    studentLinks.forEach(link => {
        link.addEventListener("click", function () {
            // Remove "active" class from all links
            studentLinks.forEach(link => {
                link.classList.remove("active");
            });

            // Add "active" class to the clicked link
            this.classList.add("active");

            // You can fetch student info or perform other actions here
            const userId = this.dataset.userid;
            fetchStudentInfo(userId); // Example function call
        });
    });

    // Function to fetch and display the information of the first student when the page loads
    function fetchFirstStudentInfo() {
        // Get the userId of the first student
        const firstStudentLink = studentLinks[0];
        const userId = firstStudentLink.dataset.userid;

        // Fetch student information and display it in .student-info div
        fetchStudentInfo(userId);

        firstStudentLink.classList.add("active");
    }

    // Call the function to fetch the first student's information when the page loads
    fetchFirstStudentInfo();

    function fetchStudentInfo(userId) {
        // Fetch student information and display it in .student-info div
        fetch('fetch_student_info.php?userid=' + userId)
            .then(response => response.text())
            .then(data => {
                studentInfo.innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }

});