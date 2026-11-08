## Part H: Reflection Questions

### 1. Why does the exception trace show a vendor file even though the mistake is in your own code?

Laravel's internal methods are located inside the vendor folder, so the exception trace may show a vendor file where the error was detected. However, the actual mistake was in my `MovieController.php`, where I accidentally called `Movie::withh('genre')` instead of `Movie::with('genre')`. Opening the application frame in the trace helped me identify the exact line in my own code.

### 2. Why is logging useful compared to relying only on error pages?

Logging is useful because it records important application events even when the user does not see an error page. In my Movie Collection project, the `Log::info()` statement records the ID of the movie that was updated, making it easier to track changes and investigate application activity.

### 3. When should you use a 403 error instead of redirecting the user with a message?

A 403 error is appropriate when the user is not allowed to perform an action because of an application rule. In my project, deleting the last movie belonging to a genre is forbidden, so the application returns a 403 response. A redirect with a message is more appropriate when an action succeeds or when the user can correct an issue and continue.