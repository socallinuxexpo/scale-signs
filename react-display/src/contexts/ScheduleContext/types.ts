// react-display/src/contexts/ScheduleContext/types.ts

export interface Presentation {
	Name: string;
	Description: string;
	Location: string;
	StartTime: string;
	EndTime: string;
	Speakers: string;
	Topic: string;
}

export interface ScheduleData {
	Presentations: Presentation[];
	lastUpdateTime: string;
	lastRefreshTime: string;
	contentHash: string;
	sessionCount: number;
}

export interface SessionStatus {
	isInProgress: boolean; // Currently running
	isStartingSoon: boolean; // Starting within 10 minutes
	isPast: boolean; // Already ended
	minutesRemaining: number; // For in-progress sessions
	minutesUntilStart: number; // For upcoming sessions
}

export interface SessionWithStatus extends Presentation {
	status: SessionStatus;
}

export interface ScheduleContextType {
	schedule: ScheduleData | null;
	isLoading: boolean;
	error: Error | null;
	isStaleData: boolean;
	lastRefreshTime: number;
	refreshSchedule: () => Promise<void>;
	getCurrentAndUpcomingSessions: () => SessionWithStatus[];
}
