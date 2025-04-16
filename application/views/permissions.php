<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị phân quyền</title>
    <?php
        require_once(APPPATH . 'views/include-css.php');
    ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .conflict-role {
            position: relative;
        }
        .conflict-role::after {
            content: "Xung đột quyền";
            position: absolute;
            top: -20px;
            left: 0;
            background-color: #f87171;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .conflict-role:hover::after {
            opacity: 1;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div id="app">
<div class="main-wrapper main-wrapper-1">
<?php require_once(APPPATH . 'views/include-header.php'); ?>
    <div class="container mx-auto px-4 py-8">
        <!-- Main Content -->
        <div class="main-content" style="min-height: 318px;">
                <section class="section">
                    <div class="section-header">
                        <h1 class="text-xl font-semibold text-gray-700 mb-4">Quản trị phân quyền người dùng</h1>
                        </div>
                    <div class="section-body">
                        <div class="bg-white rounded-lg shadow-md p-6 mb-6 fade-in">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                            <div>
                                <label for="rmCode" class="block text-sm font-medium text-gray-700 mb-1">Mã RM</label>
                                <input type="text" id="rmCode" maxlength="50" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="hrisCode" class="block text-sm font-medium text-gray-700 mb-1">Mã HRIS</label>
                                <input type="text" id="hrisCode" maxlength="50" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập</label>
                                <input type="text" id="username" maxlength="50" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="fullname" class="block text-sm font-medium text-gray-700 mb-1">Tên đầy đủ</label>
                                <input type="text" id="fullname" maxlength="100" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button id="searchBtn" class="btn btn-primary">
                                <i class="fas fa-search mr-2"></i> Tìm kiếm
                            </button>
                        </div>
                    </div>
                    </div>

        <!-- Results Section -->
        <div id="resultsSection" class="hidden bg-white rounded-lg shadow-md p-6 mb-6 fade-in">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-700">Kết quả tìm kiếm</h2>
                <span id="resultCount" class="text-sm text-gray-500">0 người dùng</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" id="selectAll" class="rounded text-blue-600 focus:ring-blue-500">
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã RM</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã HRIS</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên đăng nhập</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên đầy đủ</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vai trò hiện tại</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Users will be populated here -->
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div id="pagination" class="flex items-center justify-between mt-4 hidden">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Trước
                    </button>
                    <button class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Sau
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Hiển thị <span id="startItem" class="font-medium">1</span> đến <span id="endItem" class="font-medium">10</span> của <span id="totalItems" class="font-medium">100</span> kết quả
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <button id="prevPage" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Trước</span>
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <div id="pageNumbers" class="flex">
                                <!-- Page numbers will be added here -->
                            </div>
                            <button id="nextPage" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Sau</span>
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Assignment Section -->
        <div id="roleAssignmentSection" class="hidden bg-white rounded-lg shadow-md p-6 fade-in">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Phân quyền cho người dùng</h2>
            
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-700 mb-2">Người dùng được chọn:</h3>
                <div id="selectedUsers" class="flex flex-wrap gap-2 mb-4">
                    <!-- Selected users will appear here -->
                </div>
            </div>
            
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Danh sách quyền:</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    
                    <div class="border rounded-md p-4">
                    <div class="flex items-center mb-2">
                        <input type="radio" id="role-rm" name="role" value="RM">
                        <label for="role-rm" class="ml-2 block text-sm font-medium text-gray-700">RM (Relationship Manager)</label>
                    </div>
                    <p class="text-xs text-gray-500">Quản lý quan hệ khách hàng, tạo và theo dõi hợp đồng</p>
                    </div>

                    <div class="border rounded-md p-4">
                    <div class="flex items-center mb-2">
                        <input type="radio" id="role-cbql" name="role" value="CBQL">
                        <label for="role-cbql" class="ml-2 block text-sm font-medium text-gray-700">CBQL (Cán bộ quản lý)</label>
                    </div>
                    <p class="text-xs text-gray-500">Quản lý nhân viên, phê duyệt các yêu cầu quan trọng</p>
                    </div>

                    <div class="border rounded-md p-4">
                    <div class="flex items-center mb-2">
                        <input type="radio" id="role-admin" name="role" value="ADMIN">
                        <label for="role-admin" class="ml-2 block text-sm font-medium text-gray-700">ADMIN (Quản trị hệ thống)</label>
                    </div>
                    <p class="text-xs text-gray-500">Toàn quyền quản trị hệ thống</p>
                    </div>
                    
                </div>
            </div>

            
            <div class="flex justify-end space-x-3">
                <button id="cancelBtn" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                    Hủy bỏ
                </button>
                <button id="saveBtn" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i> Lưu lại
                </button>
            </div>
        </div>

        <!-- Success Modal -->
        <div id="successModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 fade-in">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Thành công!</h3>
                </div>
                <p class="text-sm text-gray-500 mb-4">Phân quyền đã được cập nhật thành công.</p>
                <div class="flex justify-end">
                    <button id="closeSuccessModal" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sample data - in a real app this would come from an API
        const sampleUsers = [
            { id: 1, rmCode: 'RM001', hrisCode: 'HR001', username: 'user1', fullname: 'Nguyễn Văn A', currentRoles: ['NV'], status: 'active' },
            { id: 2, rmCode: 'RM002', hrisCode: 'HR002', username: 'user2', fullname: 'Trần Thị B', currentRoles: ['TV'], status: 'active' },
            { id: 3, rmCode: 'RM003', hrisCode: 'HR003', username: 'user3', fullname: 'Lê Văn C', currentRoles: ['KT'], status: 'active' },
            { id: 4, rmCode: 'RM004', hrisCode: 'HR004', username: 'user4', fullname: 'Phạm Thị D', currentRoles: ['RM'], status: 'active' },
            { id: 5, rmCode: 'RM005', hrisCode: 'HR005', username: 'user5', fullname: 'Hoàng Văn E', currentRoles: ['CBQL'], status: 'active' },
            { id: 6, rmCode: 'RM006', hrisCode: 'HR006', username: 'user6', fullname: 'Vũ Thị F', currentRoles: ['ADMIN'], status: 'active' },
            { id: 7, rmCode: 'RM007', hrisCode: 'HR007', username: 'user7', fullname: 'Đặng Văn G', currentRoles: ['NV', 'TV'], status: 'active' },
            { id: 8, rmCode: 'RM008', hrisCode: 'HR008', username: 'user8', fullname: 'Bùi Thị H', currentRoles: [], status: 'active' },
            { id: 9, rmCode: 'RM009', hrisCode: 'HR009', username: 'user9', fullname: 'Đỗ Văn I', currentRoles: ['KT', 'TV'], status: 'active' },
            { id: 10, rmCode: 'RM010', hrisCode: 'HR010', username: 'user10', fullname: 'Ngô Thị K', currentRoles: ['RM'], status: 'active' }
        ];

        // Conflict rules - which roles cannot be assigned together
        const roleConflicts = {
            'RM': ['CBQL'],
            'CBQL': ['RM'],
            'ADMIN': [] // Admin can have any other role
        };

        // State
        let currentPage = 1;
        const usersPerPage = 5;
        let filteredUsers = [];
        let selectedUsers = [];
        let selectedRoles = [];

        // DOM Elements
        const searchBtn = document.getElementById('searchBtn');
        const resultsSection = document.getElementById('resultsSection');
        const userTableBody = document.getElementById('userTableBody');
        const resultCount = document.getElementById('resultCount');
        const pagination = document.getElementById('pagination');
        const prevPage = document.getElementById('prevPage');
        const nextPage = document.getElementById('nextPage');
        const pageNumbers = document.getElementById('pageNumbers');
        const startItem = document.getElementById('startItem');
        const endItem = document.getElementById('endItem');
        const totalItems = document.getElementById('totalItems');
        const selectAll = document.getElementById('selectAll');
        const roleAssignmentSection = document.getElementById('roleAssignmentSection');
        const selectedUsersContainer = document.getElementById('selectedUsers');
        const roleCheckboxes = document.querySelectorAll('.role-checkbox');
        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const successModal = document.getElementById('successModal');
        const closeSuccessModal = document.getElementById('closeSuccessModal');

        // Event Listeners
        searchBtn.addEventListener('click', handleSearch);
        prevPage.addEventListener('click', () => changePage(currentPage - 1));
        nextPage.addEventListener('click', () => changePage(currentPage + 1));
        selectAll.addEventListener('change', toggleSelectAll);
        saveBtn.addEventListener('click', saveRoles);
        cancelBtn.addEventListener('click', cancelRoleAssignment);
        closeSuccessModal.addEventListener('click', () => successModal.classList.add('hidden'));

        // Role checkbox change event
        roleCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const role = this.dataset.role;
                const conflicts = this.dataset.conflicts ? this.dataset.conflicts.split(',') : [];
                
                if (this.checked) {
                    // Check for conflicts
                    const hasConflict = conflicts.some(conflictRole => 
                        selectedRoles.includes(conflictRole)
                    );
                    
                    if (hasConflict) {
                        alert(`Không thể đồng thời gán quyền ${role} và ${conflicts.join(', ')}`);
                        this.checked = false;
                        return;
                    }
                    
                    // Add to selected roles
                    selectedRoles.push(role);
                    
                    // Disable conflicting roles
                    roleCheckboxes.forEach(cb => {
                        if (conflicts.includes(cb.dataset.role)) {
                            cb.disabled = true;
                        }
                    });
                } else {
                    // Remove from selected roles
                    selectedRoles = selectedRoles.filter(r => r !== role);
                    
                    // Enable previously conflicting roles
                    roleCheckboxes.forEach(cb => {
                        if (conflicts.includes(cb.dataset.role)) {
                            const hasOtherConflict = roleConflicts[cb.dataset.role].some(r => 
                                selectedRoles.includes(r)
                            );
                            if (!hasOtherConflict) {
                                cb.disabled = false;
                            }
                        }
                    });
                }
            });
        });

        // Functions
        function handleSearch() {
            const rmCode = document.getElementById('rmCode').value.trim().toLowerCase();
            const hrisCode = document.getElementById('hrisCode').value.trim().toLowerCase();
            const username = document.getElementById('username').value.trim().toLowerCase();
            const fullname = document.getElementById('fullname').value.trim().toLowerCase();
            
            // Filter users based on search criteria
            filteredUsers = sampleUsers.filter(user => {
                return (rmCode === '' || user.rmCode.toLowerCase().includes(rmCode)) &&
                       (hrisCode === '' || user.hrisCode.toLowerCase().includes(hrisCode)) &&
                       (username === '' || user.username.toLowerCase().includes(username)) &&
                       (fullname === '' || user.fullname.toLowerCase().includes(fullname)) &&
                       user.status === 'active';
            });
            
            // Update UI
            resultCount.textContent = `${filteredUsers.length} người dùng`;
            currentPage = 1;
            renderUsers();
            renderPagination();
            
            // Show results section
            resultsSection.classList.remove('hidden');
        }

        function renderUsers() {
            userTableBody.innerHTML = '';
            
            const startIndex = (currentPage - 1) * usersPerPage;
            const endIndex = Math.min(startIndex + usersPerPage, filteredUsers.length);
            const usersToDisplay = filteredUsers.slice(startIndex, endIndex);
            
            usersToDisplay.forEach(user => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.dataset.userId = user.id;
                
                // Checkbox
                const checkboxCell = document.createElement('td');
                checkboxCell.className = 'px-6 py-4 whitespace-nowrap';
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'user-checkbox rounded text-blue-600 focus:ring-blue-500';
                checkbox.dataset.userId = user.id;
                checkbox.addEventListener('change', toggleUserSelection);
                checkboxCell.appendChild(checkbox);
                row.appendChild(checkboxCell);
                
                // RM Code
                const rmCell = document.createElement('td');
                rmCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
                rmCell.textContent = user.rmCode;
                row.appendChild(rmCell);
                
                // HRIS Code
                const hrisCell = document.createElement('td');
                hrisCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
                hrisCell.textContent = user.hrisCode;
                row.appendChild(hrisCell);
                
                // Username
                const userCell = document.createElement('td');
                userCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
                userCell.textContent = user.username;
                row.appendChild(userCell);
                
                // Fullname
                const nameCell = document.createElement('td');
                nameCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
                nameCell.textContent = user.fullname;
                row.appendChild(nameCell);
                
                // Current Roles
                const rolesCell = document.createElement('td');
                rolesCell.className = 'px-6 py-4 whitespace-nowrap text-sm text-gray-500';
                rolesCell.textContent = user.currentRoles.join(', ') || 'Không có';
                row.appendChild(rolesCell);
                
                // Status
                const statusCell = document.createElement('td');
                statusCell.className = 'px-6 py-4 whitespace-nowrap';
                const statusSpan = document.createElement('span');
                statusSpan.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800';
                statusSpan.textContent = 'Hoạt động';
                statusCell.appendChild(statusSpan);
                row.appendChild(statusCell);
                
                userTableBody.appendChild(row);
            });
            
            // Update pagination info
            startItem.textContent = startIndex + 1;
            endItem.textContent = endIndex;
            totalItems.textContent = filteredUsers.length;
            
            // Show pagination if needed
            if (filteredUsers.length > usersPerPage) {
                pagination.classList.remove('hidden');
            } else {
                pagination.classList.add('hidden');
            }
        }

        function renderPagination() {
            pageNumbers.innerHTML = '';
            
            const totalPages = Math.ceil(filteredUsers.length / usersPerPage);
            
            // Previous button state
            prevPage.disabled = currentPage === 1;
            
            // Next button state
            nextPage.disabled = currentPage === totalPages;
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.className = `relative inline-flex items-center px-4 py-2 border text-sm font-medium ${
                    i === currentPage ? 'bg-blue-50 border-blue-500 text-blue-600' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'
                }`;
                pageBtn.textContent = i;
                pageBtn.addEventListener('click', () => changePage(i));
                pageNumbers.appendChild(pageBtn);
            }
        }

        function changePage(page) {
            if (page < 1 || page > Math.ceil(filteredUsers.length / usersPerPage)) return;
            currentPage = page;
            renderUsers();
            renderPagination();
        }

        function toggleSelectAll(e) {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
                const event = new Event('change');
                checkbox.dispatchEvent(event);
            });
        }

        function toggleUserSelection(e) {
            const userId = parseInt(e.target.dataset.userId);
            
            if (e.target.checked) {
                if (!selectedUsers.includes(userId)) {
                    selectedUsers.push(userId);
                }
            } else {
                selectedUsers = selectedUsers.filter(id => id !== userId);
                selectAll.checked = false;
            }
            
            // Update selected users display
            updateSelectedUsersDisplay();
            
            // Show/hide role assignment section
            if (selectedUsers.length > 0) {
                roleAssignmentSection.classList.remove('hidden');
                
                // For demo purposes, we'll just show the first user's current roles
                const firstUser = sampleUsers.find(u => u.id === selectedUsers[0]);
                if (firstUser) {
                    // Reset all checkboxes
                    roleCheckboxes.forEach(checkbox => {
                        checkbox.checked = false;
                        checkbox.disabled = false;
                    });
                    
                    // Check the user's current roles
                    selectedRoles = [...firstUser.currentRoles];
                    firstUser.currentRoles.forEach(role => {
                        const checkbox = document.querySelector(`.role-checkbox[data-role="${role}"]`);
                        if (checkbox) {
                            checkbox.checked = true;
                            
                            // Disable conflicting roles
                            const conflicts = roleConflicts[role] || [];
                            conflicts.forEach(conflictRole => {
                                const conflictCheckbox = document.querySelector(`.role-checkbox[data-role="${conflictRole}"]`);
                                if (conflictCheckbox) {
                                    conflictCheckbox.disabled = true;
                                }
                            });
                        }
                    });
                }
            } else {
                roleAssignmentSection.classList.add('hidden');
                selectedRoles = [];
            }
        }

        function updateSelectedUsersDisplay() {
            selectedUsersContainer.innerHTML = '';
            
            selectedUsers.forEach(userId => {
                const user = sampleUsers.find(u => u.id === userId);
                if (user) {
                    const userBadge = document.createElement('div');
                    userBadge.className = 'flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm';
                    userBadge.innerHTML = `
                        ${user.fullname} (${user.username})
                        <button class="ml-2 text-blue-600 hover:text-blue-800" data-user-id="${user.id}">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    selectedUsersContainer.appendChild(userBadge);
                    
                    // Add event listener to remove button
                    const removeBtn = userBadge.querySelector('button');
                    removeBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const userIdToRemove = parseInt(e.target.closest('button').dataset.userId);
                        selectedUsers = selectedUsers.filter(id => id !== userIdToRemove);
                        
                        // Uncheck the checkbox in the table
                        const checkbox = document.querySelector(`.user-checkbox[data-user-id="${userIdToRemove}"]`);
                        if (checkbox) {
                            checkbox.checked = false;
                        }
                        
                        // Update UI
                        updateSelectedUsersDisplay();
                        
                        if (selectedUsers.length === 0) {
                            roleAssignmentSection.classList.add('hidden');
                        }
                    });
                }
            });
        }

        function saveRoles() {
            // In a real app, this would send the data to the server
            console.log('Saving roles for users:', selectedUsers);
            console.log('New roles:', selectedRoles);
            
            // Show success modal
            successModal.classList.remove('hidden');
            
            // Reset selection after saving
            selectedUsers = [];
            selectedRoles = [];
            updateSelectedUsersDisplay();
            roleAssignmentSection.classList.add('hidden');
            
            // Uncheck all user checkboxes
            document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            selectAll.checked = false;
            
            // For demo purposes, update the sample data
            selectedUsers.forEach(userId => {
                const user = sampleUsers.find(u => u.id === userId);
                if (user) {
                    user.currentRoles = [...selectedRoles];
                }
            });
            
            // Re-render the table to show updated roles
            renderUsers();
        }

        function cancelRoleAssignment() {
            selectedUsers = [];
            selectedRoles = [];
            updateSelectedUsersDisplay();
            roleAssignmentSection.classList.add('hidden');
            
            // Uncheck all user checkboxes
            document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            selectAll.checked = false;
            
            // Reset role checkboxes
            roleCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
                checkbox.disabled = false;
            });
        }
    </script>
    <?php
    require_once(APPPATH . 'views/include-js.php');
    ?>
</body>

</html>