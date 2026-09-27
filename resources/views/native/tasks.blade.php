<native:scroll-view class="w-full h-full bg-slate-950">
    <native:column class="w-full gap-5 px-5 pt-8 pb-12 safe-area">
        <native:row class="w-full items-center justify-between">
            <native:column class="gap-1">
                <native:text class="text-sm font-semibold text-violet-300">FOCUSBOARD / TODAY</native:text>
                <native:text class="text-4xl font-extrabold text-white">Make space for progress.</native:text>
            </native:column>
            <native:icon name="check" :size="32" class="text-violet-300" />
        </native:row>

        <native:column class="w-full gap-3 rounded-3xl bg-violet-600 p-5">
            <native:text class="text-sm font-semibold text-violet-100">YOUR MOMENTUM</native:text>
            <native:text class="text-2xl font-bold text-white">{{ $completeCount }} of {{ $totalCount }} tasks done</native:text>
            <native:text class="text-sm text-violet-100">A little progress still counts.</native:text>
        </native:column>

        <native:column class="w-full gap-3 rounded-2xl bg-slate-800 p-4">
            <native:text class="text-lg font-bold text-white">Capture a task</native:text>
            <native:text class="text-sm font-semibold text-slate-300">NEW TASK</native:text>
            <native:bare-text-input native:key="task-input-{{ $inputVersion }}" ref="task-input" placeholder="e.g. Review the chapter" native:model.debounce.750ms="draft" @submit="add" max-length="140" a11y-label="New task" color="slate-900" class="w-full rounded-xl bg-white p-3" />
            @if ($error !== '')
                <native:text class="text-sm font-semibold text-rose-300">{{ $error }}</native:text>
            @endif
            <native:pressable ref="add-task" @press="add" class="w-full items-center rounded-xl bg-violet-500 p-3">
                <native:text class="text-base font-bold text-white">Add task</native:text>
            </native:pressable>
        </native:column>

        <native:row class="w-full items-center justify-between">
            <native:text class="text-xl font-bold text-white">Your list</native:text>
            <native:text class="text-sm text-slate-400">{{ $totalCount }} total</native:text>
        </native:row>

        @forelse ($tasks as $task)
            <native:row class="w-full items-center gap-3 rounded-2xl bg-slate-800 p-4">
                <native:pressable ref="toggle-{{ $task->id }}" @press="toggle({{ $task->id }})" class="flex-1">
                    <native:row class="items-center gap-3">
                        <native:icon name="{{ $task->is_complete ? 'check' : 'clock' }}" :size="23" class="text-violet-300" />
                        <native:text class="flex-1 text-base font-semibold text-white">{{ $task->title }}</native:text>
                    </native:row>
                </native:pressable>
                <native:pressable ref="remove-{{ $task->id }}" @press="remove({{ $task->id }})" a11y-label="Delete {{ $task->title }}" class="w-11 h-11 items-center justify-center">
                    <native:icon name="delete" :size="20" a11y-label="Delete {{ $task->title }}" class="text-slate-400" />
                </native:pressable>
            </native:row>
        @empty
            <native:column class="w-full items-center gap-2 rounded-2xl bg-slate-800 p-6">
                <native:icon name="check" :size="32" class="text-violet-300" />
                <native:text class="text-base font-semibold text-white">A clear slate</native:text>
                <native:text class="text-sm text-slate-400">Add your first task above.</native:text>
            </native:column>
        @endforelse
    </native:column>
</native:scroll-view>
