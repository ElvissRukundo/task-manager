document.getElementById('add-task-btn').addEventListener('click', addTask);
document.getElementById('category-filter').addEventListener('change', filterTasks);
let tasks = [];

function addTask() {
    const taskInput = document.getElementById('task-input');
    const category = prompt('Enter category (Work, Personal, Shopping):');
    const taskText = taskInput.value.trim();
    if (taskText) {
        const task = {
            id: Date.now(),
            text: taskText,
            category: category || 'Uncategorized',
            completed: false
        };
        tasks.push(task);
        renderTasks();
        taskInput.value = '';
    }
}

function renderTasks() {
    const taskList = document.getElementById('task-list');
    taskList.innerHTML = '';
    tasks.forEach(task => {
        const taskItem = document.createElement('li');
        taskItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
        taskItem.innerHTML = `
            <span class="${task.completed ? 'completed-task' : ''}">
                ${task.text}
                <span class="task-category">(${task.category})</span>
            </span>
            <div>
                <button class="btn btn-sm btn-success me-2" onclick="toggleComplete(${task.id})">Complete</button>
                <button class="btn btn-sm btn-warning me-2" onclick="editTask(${task.id})">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="deleteTask(${task.id})">Delete</button>
            </div>
        `;
        taskList.appendChild(taskItem);
    });
}

function toggleComplete(id) {
    const task = tasks.find(task => task.id === id);
    if (task) {
        task.completed = !task.completed;
        renderTasks();
    }
}

function editTask(id) {
    const task = tasks.find(task => task.id === id);
    if (task) {
        const newText = prompt('Edit task:', task.text);
        if (newText) {
            task.text = newText.trim();
            renderTasks();
        }
    }
}

function deleteTask(id) {
    tasks = tasks.filter(task => task.id !== id);
    renderTasks();
}

function filterTasks() {
    const filter = document.getElementById('category-filter').value;
    const filteredTasks = filter === 'All' ? tasks : tasks.filter(task => task.category === filter);
    const taskList = document.getElementById('task-list');
    taskList.innerHTML = '';
    filteredTasks.forEach(task => {
        const taskItem = document.createElement('li');
        taskItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
        taskItem.innerHTML = `
            <span class="${task.completed ? 'completed-task' : ''}">
                ${task.text}
                <span class="task-category">(${task.category})</span>
            </span>
            <div>
                <button class="btn btn-sm btn-success me-2" onclick="toggleComplete(${task.id})">Complete</button>
                <button class="btn btn-sm btn-warning me-2" onclick="editTask(${task.id})">Edit</button>
                <button class="btn btn-sm btn-danger" onclick="deleteTask(${task.id})">Delete</button>
            </div>
        `;
        taskList.appendChild(taskItem);
    });
}