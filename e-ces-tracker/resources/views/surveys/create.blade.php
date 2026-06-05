<x-layouts.dashboard>
    <div class="max-w-4xl mx-auto p-6 space-y-8" x-data="{ 
        questions: [{ text: '', type: 'text', required: true, choices: ['Choice 1', 'Choice 2'] }],
        addQuestion() {
            this.questions.push({ text: '', type: 'text', required: true, choices: ['Choice 1', 'Choice 2'] });
        },
        removeQuestion(index) {
            if (this.questions.length > 1) {
                this.questions.splice(index, 1);
            }
        },
        addChoice(qIndex) {
            this.questions[qIndex].choices.push('Choice ' + (this.questions[qIndex].choices.length + 1));
        },
        removeChoice(qIndex, cIndex) {
            if (this.questions[qIndex].choices.length > 1) {
                this.questions[qIndex].choices.splice(cIndex, 1);
            }
        }
    }">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold text-black font-inter tracking-tight">Survey Builder</h1>
                <p class="text-emerald-900 font-semibold text-base font-inter">Create a new assessment for {{ auth()->user()->department }} department.</p>
            </div>
            <a href="{{ route('surveys.index') }}" class="text-gray-500 hover:text-gray-700 font-bold text-sm flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to List
            </a>
        </div>

        <form action="{{ route('surveys.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- General Settings -->
            <div class="bg-white border-2 border-emerald-100 rounded-2xl p-8 shadow-sm space-y-6">
                <div class="flex items-center gap-3 border-b border-emerald-50 pb-4">
                    <div class="p-2 bg-emerald-50 rounded-lg">
                        <img src="{{ asset('images/icons/settings.png') }}" class="w-5 h-5 opacity-70" alt="" onerror="this.onerror=null; this.src='/images/icons/plus-circle.png';">
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">General Settings</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <div class="md:col-span-8 space-y-2">
                        <label for="title" class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Survey Title</label>
                        <input type="text" name="title" id="title" required value="{{ old('title') }}"
                               class="w-full bg-gray-50 border-emerald-100 rounded-xl px-4 py-3 text-sm focus:ring-emerald-500 focus:border-emerald-500 transition-all font-medium border-2"
                               placeholder="e.g. Community Satisfaction Assessment 2026">
                        @error('title') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-4 space-y-2">
                        <label for="status" class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Initial Status</label>
                        <select name="status" id="status" class="w-full bg-gray-50 border-emerald-100 rounded-xl px-4 py-3 text-sm font-bold text-gray-700 border-2">
                            <option value="draft">Draft (Private)</option>
                            <option value="active">Active (Public)</option>
                            <option value="closed">Closed (Finished)</option>
                        </select>
                    </div>

                    <div class="md:col-span-12 space-y-2">
                        <label for="project_id" class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Target Project</label>
                        <select name="project_id" id="project_id" required class="w-full bg-gray-50 border-emerald-100 rounded-xl px-4 py-3 text-sm font-bold text-gray-700 border-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Select a Project...</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                    CES-Project #{{ str_pad($project->id, 3, '0', STR_PAD_LEFT) }} - {{ $project->project_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-12 space-y-2">
                        <label for="description" class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Description</label>
                        <textarea name="description" id="description" rows="2" 
                                  class="w-full bg-gray-50 border-emerald-100 rounded-xl px-4 py-3 text-sm focus:ring-emerald-500 focus:border-emerald-500 transition-all font-medium border-2"
                                  placeholder="Describe the purpose of this survey...">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Question Builder -->
            <div class="space-y-6">
                <div class="flex justify-between items-center bg-emerald-50/50 p-4 rounded-xl border border-emerald-100">
                    <h3 class="text-xl font-bold text-gray-900">Questions</h3>
                    <button type="button" @click="addQuestion()" 
                            class="bg-emerald-800 text-white px-6 py-2 rounded-xl text-xs font-bold hover:bg-emerald-900 transition-all flex items-center gap-2 shadow-md transform hover:scale-105 active:scale-95">
                        <img src="{{ asset('images/icons/plus-circle.png') }}" class="w-4 h-4 brightness-0 invert" alt="" onerror="this.onerror=null; this.src='/images/icons/plus-circle.png';">
                        Add New Question
                    </button>
                </div>

                <div class="space-y-6">
                    <template x-for="(question, index) in questions" :key="index">
                        <div class="bg-white border-2 border-emerald-100 rounded-2xl p-8 shadow-sm flex flex-col gap-6 animate-fade-in group hover:border-emerald-400 transition-all relative overflow-hidden">
                            <!-- Question Meta & Actions -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-800 font-black text-lg shadow-inner" x-text="index + 1"></div>
                                    <div>
                                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Question Layer</p>
                                        <p class="text-xs font-bold text-gray-400" x-text="question.type.toUpperCase()"></p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-6">
                                    <label class="flex items-center gap-2 cursor-pointer group/toggle">
                                        <input type="checkbox" :name="'questions['+index+'][is_required]'" x-model="question.required" 
                                               class="w-4 h-4 text-emerald-600 border-emerald-200 rounded focus:ring-emerald-500">
                                        <span class="text-[10px] font-black text-gray-400 group-hover/toggle:text-emerald-700 transition-colors uppercase tracking-widest">Required</span>
                                    </label>
                                    <button type="button" @click="removeQuestion(index)" x-show="questions.length > 1"
                                            class="p-2 bg-red-50 text-red-400 hover:text-red-600 hover:bg-red-100 rounded-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                                <div class="md:col-span-8 space-y-2">
                                    <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest">Prompt / Question Text</label>
                                    <input type="text" :name="'questions['+index+'][question_text]'" required x-model="question.text"
                                           class="w-full bg-gray-50 border-emerald-50 rounded-xl px-4 py-3 text-sm focus:ring-emerald-500 focus:border-emerald-500 transition-all font-bold border-2"
                                           placeholder="e.g. How satisfied were you with the workshop?">
                                </div>
                                <div class="md:col-span-4 space-y-2">
                                    <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest">Response Architecture</label>
                                    <select :name="'questions['+index+'][type]'" x-model="question.type"
                                            class="w-full bg-gray-50 border-emerald-100 rounded-xl px-4 py-3 text-sm font-black text-emerald-900 focus:ring-emerald-500 focus:border-emerald-500 border-2">
                                        <option value="text">Single Text Line</option>
                                        <option value="scale">Rating Scale (1-5)</option>
                                        <option value="multiple_choice">Multiple Choice List</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Dynamic Logic Areas -->
                            <div class="border-t border-emerald-50 pt-6 mt-2">
                                <!-- Multiple Choice Logic -->
                                <div x-show="question.type === 'multiple_choice'" x-transition class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <label class="block text-[9px] font-black text-emerald-600 uppercase tracking-widest">Choices Configuration</label>
                                        <button type="button" @click="addChoice(index)"
                                                class="text-[9px] font-black text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-200 hover:bg-emerald-100 uppercase tracking-widest">
                                            + Add Choice
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <template x-for="(choice, cIndex) in question.choices" :key="cIndex">
                                            <div class="flex items-center gap-2 group/opt animate-fade-in">
                                                <div class="w-6 h-6 rounded-md bg-emerald-50 border border-emerald-200 flex items-center justify-center text-[10px] font-black text-emerald-700" x-text="cIndex + 1"></div>
                                                <input type="text" :name="'questions['+index+'][choices]['+cIndex+']'" required x-model="question.choices[cIndex]"
                                                       class="flex-grow bg-white border-emerald-100 rounded-lg px-3 py-1.5 text-xs font-bold text-gray-700 focus:border-emerald-500 border-2">
                                                <button type="button" @click="removeChoice(index, cIndex)" x-show="question.choices.length > 1"
                                                        class="opacity-0 group-hover/opt:opacity-100 text-red-300 hover:text-red-500 transition-all p-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Scale Preview -->
                                <div x-show="question.type === 'scale'" x-transition class="space-y-3">
                                    <label class="block text-[9px] font-black text-emerald-600 uppercase tracking-widest">Visual Preview</label>
                                    <div class="flex gap-4">
                                        <template x-for="i in 5" :key="i">
                                            <div class="w-10 h-10 rounded-xl bg-emerald-50 border-2 border-emerald-100 flex items-center justify-center text-xs font-black text-emerald-400" x-text="i"></div>
                                        </template>
                                        <div class="flex items-center text-[10px] font-bold text-emerald-900 opacity-40 uppercase tracking-widest ml-2">Rating Array (1 to 5)</div>
                                    </div>
                                </div>

                                <!-- Text Preview -->
                                <div x-show="question.type === 'text'" x-transition class="space-y-3">
                                    <label class="block text-[9px] font-black text-emerald-600 uppercase tracking-widest">User Interface</label>
                                    <div class="h-10 w-2/3 bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl flex items-center px-4">
                                        <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">Free-text input region</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-4 pt-8 border-t border-gray-100">
                <a href="{{ route('surveys.index') }}" class="px-8 py-3 rounded-xl text-sm font-bold text-gray-500 hover:bg-gray-100 transition-colors uppercase tracking-widest">
                    Discard Draft
                </a>
                <button type="submit" class="bg-emerald-800 text-white px-12 py-4 rounded-2xl text-sm font-black shadow-xl hover:bg-emerald-900 transition-all transform hover:-translate-y-1 hover:shadow-emerald-900/20 active:scale-95 uppercase tracking-widest">
                    Build and Save Survey
                </button>
            </div>
        </form>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-layouts.dashboard>
