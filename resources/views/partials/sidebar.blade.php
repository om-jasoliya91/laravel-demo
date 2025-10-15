<div class="bg-primary text-white flex-shrink-0 p-3" style="width: 250px; min-height: 100vh;">
    <a href="#" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <span class="fs-5 fw-bold">Admin Menu</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">

        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">Dashboard</a>
        </li>

        <!-- Students Menu -->
        <li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="collapse" href="#studentsMenu" role="button"
                aria-expanded="false" aria-controls="studentsMenu">
                Students ▼
            </a>
            <div class="collapse ps-3" id="studentsMenu">
                <ul class="list-unstyled fw-normal pb-1 small">
                    <li><a href="{{ route('admin.studentAdd') }}" class="nav-link text-white">Add Student</a></li>
                    <li><a href="{{ route('admin.studentView') }}" class="nav-link text-white">View Students</a></li>
                </ul>
            </div>
        </li>

        <!-- Courses Menu -->
        <li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="collapse" href="#coursesMenu" role="button"
                aria-expanded="false" aria-controls="coursesMenu">
                Courses ▼
            </a>
            <div class="collapse ps-3" id="coursesMenu">
                <ul class="list-unstyled fw-normal pb-1 small">
                    <li><a href="{{ route('admin.addCourse') }}" class="nav-link text-white">Add Course</a></li>
                    <li><a href="{{ route('admin.viewCourse') }}" class="nav-link text-white">View Courses</a></li>
                </ul>
            </div>
        </li>

        <!-- Enrollments Menu -->
        <li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="collapse" href="#enrollmentsMenu" role="button"
                aria-expanded="false" aria-controls="enrollmentsMenu">
                Enrollments ▼
            </a>
            <div class="collapse ps-3" id="enrollmentsMenu">
                <ul class="list-unstyled fw-normal pb-1 small">
                    {{-- <li><a href="{{ route('admin.enrollments.view') }}" class="nav-link text-white">View Enrollments</a></li> --}}
                </ul>
            </div>
        </li>

        <!-- Users -->
        <li class="nav-item">
            {{-- <a href="{{ route('admin.users') }}" class="nav-link text-white">Users</a> --}}
        </li>

        <!-- Logout -->
        <li class="nav-item mt-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
        </li>

    </ul>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
