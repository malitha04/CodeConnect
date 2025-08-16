# Review System

## Overview
The Review System allows clients to leave reviews and ratings for developers after project completion. This system helps build trust and credibility within the platform by providing transparent feedback about developer performance.

## Features

### For Clients
- **Leave Reviews**: Rate developers from 1-5 stars with optional comments
- **Edit Reviews**: Modify existing reviews if needed
- **Delete Reviews**: Remove reviews if necessary
- **View Review History**: Track all reviews written
- **Review Management**: Full CRUD operations on own reviews

### For Developers
- **View Received Reviews**: See all reviews from clients
- **Review Statistics**: Average rating and total review count
- **Public Profile**: Reviews are visible to potential clients
- **Performance Tracking**: Monitor rating trends over time

### For Platform
- **Quality Assurance**: Help maintain platform quality through feedback
- **Trust Building**: Enable informed hiring decisions
- **Developer Reputation**: Build developer credibility and visibility

## Database Structure

### Reviews Table
- `id` - Primary key
- `project_id` - Foreign key to projects table
- `client_id` - Foreign key to users table (reviewer)
- `developer_id` - Foreign key to users table (reviewed)
- `rating` - Integer from 1 to 5 stars
- `comment` - Text review comment (nullable)
- `status` - Enum: 'pending', 'published', 'hidden'
- `created_at` - Timestamp
- `updated_at` - Timestamp
- Unique constraint on `project_id` and `client_id`

## Routes

### Client Routes
- `GET /projects/{project}/reviews/create` - Create review form
- `POST /projects/{project}/reviews` - Store review
- `GET /my-reviews` - View reviews written by client

### Developer Routes
- `GET /received-reviews` - View reviews received by developer

### Public Routes
- `GET /reviews/{review}` - View specific review details
- `GET /developers/{developer}/reviews` - View all reviews for a developer

### Review Management Routes
- `GET /reviews/{review}/edit` - Edit review form
- `PATCH /reviews/{review}` - Update review
- `DELETE /reviews/{review}` - Delete review

## Usage

### Client Workflow
1. **Complete Project**: Project must be marked as 'completed'
2. **Leave Review**: Go to "My Hires" → "Leave a Review" for completed projects
3. **Rate Developer**: Select 1-5 stars with interactive star rating
4. **Add Comment**: Provide detailed feedback (optional)
5. **Submit Review**: Review is published immediately
6. **Manage Reviews**: Edit or delete reviews from "My Reviews"

### Developer Workflow
1. **Receive Notification**: Get notified when client leaves review
2. **View Reviews**: Check "My Reviews" for received feedback
3. **Monitor Performance**: Track average rating and review count
4. **Build Reputation**: Positive reviews improve visibility

## Rating System

### Star Ratings
- **1 Star**: Poor - Very dissatisfied
- **2 Stars**: Fair - Somewhat dissatisfied
- **3 Stars**: Good - Satisfied
- **4 Stars**: Very Good - Very satisfied
- **5 Stars**: Excellent - Extremely satisfied

### Rating Display
- Interactive star rating system in forms
- Visual star display in review listings
- Average rating calculations
- Rating text descriptions

## Security Features
- **Authorization**: Only project clients can review developers
- **One Review Per Project**: Unique constraint prevents duplicate reviews
- **Project Completion Required**: Only completed projects can be reviewed
- **Review Ownership**: Only review authors can edit/delete

## Integration Points
- **Dashboard**: Quick access links in both dashboards
- **Hires**: Review buttons for completed projects
- **Project Details**: Review links and ratings
- **Developer Profiles**: Public review display
- **Proposal System**: Review history affects developer credibility

## Components
- **Star Rating Component**: Reusable star display component
- **Review Forms**: Interactive rating and comment forms
- **Review Cards**: Consistent review display across views
- **Rating Statistics**: Summary stats for developers

## Future Enhancements
- **Review Responses**: Allow developers to respond to reviews
- **Review Moderation**: Admin approval system for reviews
- **Review Categories**: Rate specific aspects (communication, quality, etc.)
- **Review Analytics**: Detailed performance analytics
- **Review Notifications**: Email/SMS notifications for new reviews
- **Review Incentives**: Encourage review submission
- **Review Verification**: Verify project completion before review
- **Review Disputes**: Handle review disputes and appeals
