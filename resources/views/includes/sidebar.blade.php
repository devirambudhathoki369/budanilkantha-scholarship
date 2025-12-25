<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!-- Side menu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">मेनु</li>

                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="mdi mdi-desktop-mac-dashboard"></i>
                        <span data-key="t-dashboard">ड्यासबोर्ड</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="mdi mdi-cookie-settings"></i>
                        <span data-key="t-apps">आधारभुत विवरण</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="{{ route('classes.index') }}">
                                <span data-key="t-office">कक्षा प्रविष्टि</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('academicyear.index') }}">
                                <span data-key="t-institute">शैक्षिक सत्र प्रविष्टि</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('aarakshyamain.index') }}">
                                <span data-key="t-institute">आरक्षण प्रविष्टि</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('school.index') }}">
                                <span data-key="t-institute">विद्यालय प्रविष्टि</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('user.index') }}">
                                <span data-key="t-users">प्रयोगकर्ता व्यवस्थापन</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#">
                        <i class="mdi mdi-school"></i>
                        <span data-key="t-trainingmanagement">विद्यार्थी विवरण</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
