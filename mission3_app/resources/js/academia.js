
// ===== Form Validation Client-side =====
document.querySelectorAll('form[data-validate]').forEach(form => {
  form.addEventListener('submit', e => {
    let ok = true;

    form.querySelectorAll('[required]').forEach(input => {
      // hapus pesan error lama
      input.classList.remove('border-red-500');
      const old = input.parentElement.querySelector('.js-error');
      if(old) old.remove();

      // cek kosong
      if(!input.value.trim()){
        ok = false;
        input.classList.add('border-red-500');

        const err = document.createElement('p');
        err.className = 'js-error text-red-600 text-sm mt-1';
        err.textContent = `${input.name} wajib diisi.`;
        input.insertAdjacentElement('afterend', err);
      }
    });

    if(!ok) e.preventDefault();
  });
});

// ===== Custom Delete Confirmation Modal =====
const modal = document.querySelector('#confirmModal');
const msg = document.querySelector('#confirmMessage');
const cancelBtn = document.querySelector('#cancelBtn');
const okBtn = document.querySelector('#okBtn');
let targetForm = null;

document.body.addEventListener('submit', e => {
  const form = e.target;
  if (form.matches('form[data-confirm]')) {
    e.preventDefault();
    targetForm = form;

    let msgTxt = '';

    if (form.dataset.name) {
      msgTxt += form.dataset.name;
    }
    if (form.dataset.nim) {
      msgTxt += ` (NIM: ${form.dataset.nim})`;
    }
    if (form.dataset.sks) {
      msgTxt += ` (${form.dataset.sks} SKS)`;
    }

    msg.textContent = `Yakin ingin menghapus ${msgTxt}?`;
    modal.classList.remove('hidden');
  }
});

// Tombol batal → tutup modal
cancelBtn?.addEventListener('click', () => {
  modal.classList.add('hidden');
  targetForm = null;
});

// Tombol hapus → submit form target
okBtn?.addEventListener('click', () => {
  if (targetForm) {
    targetForm.submit();  
    targetForm = null;
  }
  modal.classList.add('hidden');
});

// ===== Bulk Enroll with Total SKS =====
const checkboxes = document.querySelectorAll('.js-course-check');
const totalEl = document.querySelector('#total-sks');
const btnEnrollSelected = document.querySelector('#btn-enroll-selected');

function updateTotal() {
  let total = 0;
  checkboxes.forEach(cb => {
    if (cb.checked) {
      total += parseInt(cb.dataset.sks) || 0;
    }
  });
  if (totalEl) totalEl.textContent = total;
}

checkboxes.forEach(cb => {
  cb.addEventListener('change', updateTotal);
});

btnEnrollSelected?.addEventListener('click', e => {
  e.preventDefault();
  const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);
  if (selected.length === 0) {
    alert('Pilih minimal 1 course!');
    return;
  }

  console.log('Course terpilih:', selected); // sementara debug
  // TODO: bisa diproses ke server (fetch atau form hidden)
});

// ===== Select All checkbox =====
const checkAll = document.querySelector('#checkAll');

checkAll?.addEventListener('change', () => {
  checkboxes.forEach(cb => {
    cb.checked = checkAll.checked;
  });
  updateTotal();
});


updateTotal();

// Bulk Enroll modal
const enrollModal = document.querySelector('#enrollModal');
const enrollMsg = document.querySelector('#enrollMessage');
const cancelEnrollBtn = document.querySelector('#cancelEnrollBtn');
const okEnrollBtn = document.querySelector('#okEnrollBtn');
let selectedCourses = [];

btnEnrollSelected?.addEventListener('click', e => {
  e.preventDefault();
  selectedCourses = Array.from(checkboxes)
    .filter(cb => cb.checked && !cb.disabled)
    .map(cb => cb.value);

  if (selectedCourses.length === 0) {
    alert('Pilih minimal 1 course!');
    return;
  }

  const total = Array.from(checkboxes)
    .filter(cb => cb.checked && !cb.disabled)
    .reduce((sum, cb) => sum + (parseInt(cb.dataset.sks) || 0), 0);

  enrollMsg.textContent = `Yakin mau enroll ${selectedCourses.length} course dengan total ${total} SKS?`;
  enrollModal.classList.remove('hidden');
});

cancelEnrollBtn?.addEventListener('click', () => {
  enrollModal.classList.add('hidden');
  selectedCourses = [];
});

okEnrollBtn?.addEventListener('click', () => {
  if (selectedCourses.length > 0) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = window.bulkEnrollUrl; // pakai route Laravel
    form.innerHTML = `
      <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
      ${selectedCourses.map(id => `<input type="hidden" name="course_ids[]" value="${id}">`).join('')}
    `;
    document.body.appendChild(form);
    form.submit();
  }
  enrollModal.classList.add('hidden');
});

// ===== Async Demo with setTimeout =====
const demoBtn = document.querySelector('#asyncDemoBtn');
const demoResult = document.querySelector('#asyncResult');

demoBtn?.addEventListener('click', () => {
  if (demoResult) {
    demoResult.textContent = "Loading data... (simulasi async)";
    demoResult.className = "mt-2 text-slate-600";
    setTimeout(() => {
      demoResult.textContent = "Data berhasil dimuat setelah 2 detik!";
      demoResult.className = "mt-2 text-emerald-600 font-semibold";
    }, 2000);
  }
});

// ===== Dark Mode Toggle =====
const darkToggle = document.querySelector('#darkModeToggle');
const html = document.documentElement;

// cek preferensi user di localStorage
if (localStorage.getItem('theme') === 'dark') {
  html.classList.add('dark');
} else {
  html.classList.remove('dark');
}

darkToggle?.addEventListener('click', () => {
  html.classList.toggle('dark');
  if (html.classList.contains('dark')) {
    localStorage.setItem('theme', 'dark');
  } else {
    localStorage.setItem('theme', 'light');
  }
});

// ===== Table Search & Filter =====
const searchInput = document.querySelector('#searchInput');
const filterMajor = document.querySelector('#filterMajor');
const rows = document.querySelectorAll('tbody tr');

function applyFilters() {
  const term = searchInput?.value.toLowerCase() || '';
  const major = filterMajor?.value.toLowerCase() || '';

  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    if (text.includes(term) && (major === '' || text.includes(major))) {
      row.classList.remove('hidden');
    } else {
      row.classList.add('hidden');
    }
  });
}

searchInput?.addEventListener('input', applyFilters);
filterMajor?.addEventListener('change', applyFilters);

// ===== Admin Course Search & Filter =====
const searchCourseInput = document.querySelector('#searchCourseInput');
const filterSemester = document.querySelector('#filterSemester');
const courseRows = document.querySelectorAll('table tbody tr');

function applyCourseFilters() {
  const term = searchCourseInput?.value.toLowerCase() || '';
  const sem = filterSemester?.value.toLowerCase() || '';

  courseRows.forEach(row => {
    const text = row.textContent.toLowerCase();
    if (text.includes(term) && (sem === '' || text.includes(sem))) {
      row.classList.remove('hidden');
    } else {
      row.classList.add('hidden');
    }
  });
}

searchCourseInput?.addEventListener('input', applyCourseFilters);
filterSemester?.addEventListener('change', applyCourseFilters);

// ===== Student Course Search & Filter =====
const studentSearchInput = document.querySelector('#studentSearchInput');
const studentFilterSemester = document.querySelector('#studentFilterSemester');
const studentFilterCredits = document.querySelector('#studentFilterCredits');
const studentCourseRows = document.querySelectorAll('table tbody tr');

function applyStudentCourseFilters() {
  const term = studentSearchInput?.value.toLowerCase() || '';
  const sem = studentFilterSemester?.value.toLowerCase() || '';
  const sks = studentFilterCredits?.value || '';

  studentCourseRows.forEach(row => {
    const text = row.textContent.toLowerCase();
    const matchSearch = text.includes(term);
    const matchSem = sem === '' || text.includes(sem);
    const matchSks = sks === '' || text.includes(`${sks} sks`);

    if (matchSearch && matchSem && matchSks) {
      row.classList.remove('hidden');
    } else {
      row.classList.add('hidden');
    }
  });
}

studentSearchInput?.addEventListener('input', applyStudentCourseFilters);
studentFilterSemester?.addEventListener('change', applyStudentCourseFilters);
studentFilterCredits?.addEventListener('change', applyStudentCourseFilters);

// ===== Logout Confirmation =====
const logoutBtn = document.querySelector('#logoutBtn');
const logoutModal = document.querySelector('#logoutModal');
const cancelLogoutBtn = document.querySelector('#cancelLogoutBtn');
const confirmLogoutBtn = document.querySelector('#confirmLogoutBtn');
const logoutForm = document.querySelector('#logoutForm');

logoutBtn?.addEventListener('click', () => {
  logoutModal.classList.remove('hidden');
});

cancelLogoutBtn?.addEventListener('click', () => {
  logoutModal.classList.add('hidden');
});

confirmLogoutBtn?.addEventListener('click', () => {
  logoutForm.submit();
});

// ===== Bulk Actions (Students) with Confirmation =====
const checkAllStudents = document.querySelector('#checkAllStudents');
const studentChecks = document.querySelectorAll('.student-check');
const bulkBtn = document.querySelector('#bulkActionApply');
const bulkSelect = document.querySelector('#bulkActionSelect');

const bulkModal = document.querySelector('#bulkModal');
const bulkMsg = document.querySelector('#bulkMessage');
const cancelBulkBtn = document.querySelector('#cancelBulkBtn');
const okBulkBtn = document.querySelector('#okBulkBtn');
let bulkData = null; // simpan data sebelum submit

checkAllStudents?.addEventListener('change', e => {
  studentChecks.forEach(chk => chk.checked = e.target.checked);
});

bulkBtn?.addEventListener('click', () => {
  const action = bulkSelect.value;
  const ids = Array.from(studentChecks)
                   .filter(chk => chk.checked)
                   .map(chk => chk.value);

  if (!action) {
    alert("Pilih action dulu.");
    return;
  }
  if (ids.length === 0) {
    alert("Pilih minimal 1 mahasiswa.");
    return;
  }

  let actionText = '';
  if (action === 'delete') actionText = 'hapus';
  if (action === 'activate') actionText = 'aktifkan';
  if (action === 'deactivate') actionText = 'nonaktifkan';

  bulkMsg.textContent = `Yakin ingin ${actionText} ${ids.length} mahasiswa terpilih?`;
  bulkModal.classList.remove('hidden');

  bulkData = { action, ids };
});

cancelBulkBtn?.addEventListener('click', () => {
  bulkModal.classList.add('hidden');
  bulkData = null;
});

okBulkBtn?.addEventListener('click', () => {
  if (!bulkData) return;

  const form = document.createElement('form');
  form.method = 'POST';
  form.action = '/admin/students/bulk-action';

  // CSRF
  const token = document.querySelector('meta[name="csrf-token"]').content;
  const csrf = document.createElement('input');
  csrf.type = 'hidden';
  csrf.name = '_token';
  csrf.value = token;
  form.appendChild(csrf);

  // action
  const act = document.createElement('input');
  act.type = 'hidden';
  act.name = 'action';
  act.value = bulkData.action;
  form.appendChild(act);

  // ids
  bulkData.ids.forEach(id => {
    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'ids[]';
    hidden.value = id;
    form.appendChild(hidden);
  });

  document.body.appendChild(form);
  form.submit();
});

// ===== Bulk Enroll Available Students =====
const checkAllAvailable = document.querySelector('#checkAllAvailable');
const availableChecks = document.querySelectorAll('.available-check');

checkAllAvailable?.addEventListener('change', e => {
  availableChecks.forEach(chk => chk.checked = e.target.checked);
});
