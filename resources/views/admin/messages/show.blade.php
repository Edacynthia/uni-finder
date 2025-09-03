@extends('components.layouts.app')
@section('content')
    <style type="text/css">
        .logo-gradient {
            background: linear-gradient(135deg, #ff00cc 0%, #ff9900 25%, #66ff00 50%, #00ffff 75%, #cc00ff 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShift 8s linear infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }
        
        .message-container {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.9) 0%, rgba(17, 24, 39, 0.95) 100%);
            border: 1px solid rgba(168, 85, 247, 0.3);
        }
        
        .btn-reply {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            transition: all 0.3s ease;
        }
        
        .btn-reply:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
        }
        
        .btn-resolve {
            background: linear-gradient(135deg, #059669 0%, #10B981 100%);
            transition: all 0.3s ease;
        }
        
        .btn-resolve:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.4);
        }
        
        .btn-back {
            background: linear-gradient(135deg, #6B7280 0%, #4B5563 100%);
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(107, 114, 128, 0.4);
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-pending {
            background: linear-gradient(135deg, #D97706 0%, #F59E0B 100%);
        }
        
        .status-resolved {
            background: linear-gradient(135deg, #059669 0%, #10B981 100%);
        }
        
        .input-field {
            transition: border-color 0.3s ease;
            border: 1px solid rgba(168, 85, 247, 0.3);
            background: rgba(31, 41, 55, 0.7);
        }
        
        .input-field:focus {
            border-color: #a855f7;
            box-shadow: 0 0 0 2px rgba(168, 85, 247, 0.3);
        }
        
        .glow {
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.3);
        }
    </style>

<div class="bg-[#2C2957] text-white font-chakra">
    <!-- Include Navbar Component -->
    @include('components.navbar')

    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6">
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white font-syne">Message Details</h1>
                <p class="text-purple-300 mt-1">Review the message and take action</p>
            </div>
            <a href="{{ route('admin.messages.index') }}"
               class="btn-back text-white px-4 py-2 rounded-lg font-medium inline-flex items-center self-start sm:self-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Messages
            </a>
        </div>

        @if(session('success'))
            <div class="bg-purple-300 text-purple-700 p-4 rounded-lg mb-6 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20极速赛车开奖结果记录" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-900 text-red-300 p-4 rounded-lg mb-6 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 极速赛车开奖结果记录 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="message-container rounded-xl overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-purple-500/40 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="space-y-2">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-purple-300 font-medium">From:</span>
                        <span class="ml-2 text-white">{{ $message->name }}</span>
                    </div>
                    
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-purple-300 font-medium">Email:</span>
                        <a href="mailto:{{ $message->email }}" class="ml-2 text-purple-300 hover:text-white hover:underline transition">
                            {{ $message->email }}
                        </a>
                    </div>
                    
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-purple-300 font-medium">Sent:</span>
                        <span class="ml-2 text-white">{{ $message->created_at?->toDayDateTimeString() }}</span>
                    </div>
                </div>
                
                <div>
                    @if($message->status === 'resolved')
                        <span class="status-badge status-resolved text-white inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Resolved
                        </span>
                    @else
                        <span class="status-badge status-pending text-white inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pending
                        </span>
                    @endif
                </div>
            </div>

            <div class="px-6 py-6">
                <h2 class="text-xl font-semibold text-white mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-300" fill="none" viewBox="0 0 24 极速赛车开奖结果记录4" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Message
                </h2>
                
                <div class="bg-gray-800 rounded-lg p-5 leading-relaxed whitespace-pre-line text-gray-200">
                    {{ $message->message }}
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="mailto:{{ $message->email }}"
                       class="btn-reply text-white px-5 py-3 rounded-lg font-medium inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Reply via Email
                    </a>

                    @if($message->status !== 'resolved')
                        <form action="{{ route('admin.messages.resolve', $message->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="btn-resolve text-white px-5 py-3 rounded-lg font-medium inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Mark as Resolved
                            </button>
                        </form>
                    @else
                        <span class="px-5 py-3 bg-gray-700 text-gray-300 rounded-lg font-medium inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Already Resolved
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Reply Form Section -->
        <div class="message-container rounded-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-purple-500/40">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                    Send Reply
                </h2>
            </div>
            
            <div class="px-6 py-6">
                <form action="{{ route('admin.messages.reply', $message->id) }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-white font-medium mb-2">Reply Message</label>
                        <textarea name="replyMessage" rows="5" 
                                  class="w-full input-field p-4 rounded-lg text-white"
                                  placeholder="Type your response to {{ $message->name }}..." required>{{ old('replyMessage') }}</textarea>
                        @error('replyMessage')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn-reply text-white px-5 py-3 rounded-lg font-medium inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Send Reply
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto-resize textarea as user types
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.querySelector('textarea[name="replyMessage"]');
            if (textarea) {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
                
                // Trigger initial resize
                setTimeout(() => {
                    textarea.dispatchEvent(new Event('input'));
                }, 100);
            }
        });
    </script>
</div>
@endsection