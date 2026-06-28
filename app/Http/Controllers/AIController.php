<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message', '');
        $lower = strtolower($message);

        $responses = [
            ['pattern' => '/(create|build|generate|make|set up)/', 'response' => "I'll help you build that! Here's my plan:\n\n1) Set up the project structure with best practices\n2) Create the necessary models and database schema\n3) Build the UI components with responsive design\n4) Implement the business logic and API endpoints\n5) Add tests and documentation\n\nShall I start generating the code for step 1?"],
            ['pattern' => '/(fix|debug|error|bug|issue|problem)/', 'response' => "Let me analyze the issue:\n\n🔍 **Root Cause**: The error is likely caused by a type mismatch in the data flow.\n\n**Suggested Fix**:\n1. Check the API response structure\n2. Validate input data before processing\n3. Add proper error boundaries\n\nHere's the corrected code:\n```javascript\ntry {\n  const response = await fetchData();\n  if (!response.ok) throw new Error(response.statusText);\n  return await response.json();\n} catch (error) {\n  console.error('Fetch failed:', error);\n}\n```\n\nWould you like me to apply this fix?"],
            ['pattern' => '/(explain|how does|what is|tell me about)/', 'response' => "Great question! Let me break this down:\n\n**Overview**:\nThis component follows a clean architecture pattern with separation of concerns.\n\n**Key Concepts**:\n- **Data Layer**: Handles all API communication and data persistence\n- **Business Logic**: Processes and transforms data between layers\n- **Presentation**: Renders the UI based on the current state\n\n**Data Flow**: User Action → Event Handler → State Update → Re-render\n\nThis pattern ensures testability, maintainability, and scalability. Want me to dive deeper into any specific part?"],
            ['pattern' => '/(deploy|deploying|production)/', 'response' => "I'll set up the deployment pipeline:\n\n🚀 **Deployment Plan**:\n1. ✓ Code review and tests passing\n2. ✓ Build optimization (tree-shaking, minification)\n3. ✓ Docker image creation\n4. ✓ Push to container registry\n5. ✓ Update Kubernetes deployment\n6. ✓ Health check verification\n7. ✓ DNS and SSL configuration\n8. ✓ Monitoring and alerts active\n\nEstimated time: ~3 minutes. All systems are ready!"],
            ['pattern' => '/(optimize|performance|speed|slow|fast)/', 'response' => "Here's my performance optimization strategy:\n\n⚡ **Quick Wins**:\n1. Enable lazy loading for images and components\n2. Implement code splitting for route-based chunks\n3. Add caching headers (Cache-Control, ETag)\n4. Optimize images with WebP format\n5. Minimize CSS/JS bundles\n\n📊 **Expected Results**:\n- First Contentful Paint: < 1.2s\n- Time to Interactive: < 2.0s\n- Lighthouse Score: 95+\n\nShall I implement these optimizations?"],
        ];

        foreach ($responses as $item) {
            if (preg_match($item['pattern'], $lower)) {
                return response()->json(['message' => $item['response']]);
            }
        }

        $defaults = [
            "I'm your AI development assistant! I can help you:\n\n• **Generate Code** — Create components, APIs, and full applications\n• **Debug Issues** — Analyze errors and provide fixes\n• **Explain Code** — Break down complex logic\n• **Optimize** — Improve performance and best practices\n• **Deploy** — Set up production environments\n\nWhat would you like to work on?",
            "I understand! Let me think about the best approach for this.\n\nBased on your project's architecture, I'd recommend:\n\n1. Start with a clear component structure\n2. Use type-safe data flow\n3. Implement proper error handling\n4. Add comprehensive tests\n\nWould you like me to generate the code?",
        ];

        return response()->json([
            'message' => $defaults[array_rand($defaults)]
        ]);
    }
}