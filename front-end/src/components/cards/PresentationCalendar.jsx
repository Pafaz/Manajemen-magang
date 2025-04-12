import React, { useState, useRef, useEffect } from 'react'
import FullCalendar from '@fullcalendar/react'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import './calendar-custom.css'

const Calendar = () => {
  const [view, setView] = useState('month')
  const [currentDate, setCurrentDate] = useState(new Date())
  const calendarRef = useRef(null)
  
  // Format the current date to display month and year
  const formatMonthYear = (date) => {
    const options = { month: 'long', year: 'numeric' }
    return new Intl.DateTimeFormat('en-US', options).format(date)
  }
  
  // Update the title when calendar view changes
  const updateTitle = () => {
    if (calendarRef.current) {
      const calendarApi = calendarRef.current.getApi()
      const newDate = calendarApi.getDate()
      setCurrentDate(newDate)
    }
  }
  
  // Update title on initial load
  useEffect(() => {
    if (calendarRef.current) {
      updateTitle()
    }
  }, [])
  
  const handleViewChange = (newView) => {
    setView(newView)
    
    // Map our simplified view names to FullCalendar view names
    const viewMap = {
      'day': 'timeGridDay',
      'week': 'timeGridWeek',
      'month': 'dayGridMonth'
    }
    
    // Change the calendar view
    if (calendarRef.current) {
      calendarRef.current.getApi().changeView(viewMap[newView])
      updateTitle()
    }
  }
  
  // Navigation handlers
  const handlePrev = () => {
    if (calendarRef.current) {
      calendarRef.current.getApi().prev()
      updateTitle()
    }
  }
  
  const handleNext = () => {
    if (calendarRef.current) {
      calendarRef.current.getApi().next()
      updateTitle()
    }
  }
  
  const handleToday = () => {
    if (calendarRef.current) {
      calendarRef.current.getApi().today()
      updateTitle()
    }
  }
  
  const handleAddEvent = () => {
    // This would typically open a modal or form
    alert('Add Event functionality would go here')
  }

  // Handle dates changes
  const handleDatesSet = (dateInfo) => {
    setCurrentDate(dateInfo.view.currentStart)
  }

  return (
    <div className="calendar-wrapper">
      {/* Header outside the card */}
      <div className="calendar-header">
        <div className="header-content">
          {/* Left section */}
          <div className="left-section">
            <button className="add-event-btn" onClick={handleAddEvent}>
              <span className="plus-icon">+</span> Add Event
            </button>
            <h2 className="month-title">{formatMonthYear(currentDate)}</h2>
          </div>
          
          {/* Center section - Day Week Month */}
          <div className="center-section">
            <div className="view-options">
              <button 
                className={`view-btn ${view === 'day' ? 'active' : ''}`}
                onClick={() => handleViewChange('day')}
              >
                Day
              </button>
              <button 
                className={`view-btn ${view === 'week' ? 'active' : ''}`}
                onClick={() => handleViewChange('week')}
              >
                Week
              </button>
              <button 
                className={`view-btn ${view === 'month' ? 'active' : ''}`}
                onClick={() => handleViewChange('month')}
              >
                Month
              </button>
            </div>
          </div>
          
          {/* Right section */}
          <div className="right-section">
            <div className="navigation-buttons">
              <button className="nav-btn prev" onClick={handlePrev}>
                <span>‹</span>
              </button>
              <button className="nav-btn next" onClick={handleNext}>
                <span>›</span>
              </button>
              <button className="today-btn" onClick={handleToday}>Today</button>
            </div>
          </div>
        </div>
      </div>
      
      {/* Calendar inside the card */}
      <div className="calendar-container">
        <FullCalendar
          ref={calendarRef}
          plugins={[dayGridPlugin, timeGridPlugin, interactionPlugin]}
          initialView="dayGridMonth"
          headerToolbar={false}
          events={[
            { title: 'All Day Event', start: '2025-04-01', allDay: true, backgroundColor: '#E6EFFF', textColor: '#3B82F6', borderColor: '#E6EFFF' },
            { title: '4p Repeating Event', start: '2025-04-08', backgroundColor: '#FEF9C3', textColor: '#CA8A04', borderColor: '#FEF9C3' },
            { title: '4p Repeating Event', start: '2025-04-15', backgroundColor: '#FEF9C3', textColor: '#CA8A04', borderColor: '#FEF9C3' },
            { title: '10:30a Meeting', start: '2025-04-11', backgroundColor: '#FEE2E2', textColor: '#EF4444', borderColor: '#FEE2E2' },
            { title: '12p Lunch', start: '2025-04-11', backgroundColor: '#FEE2E2', textColor: '#EF4444', borderColor: '#FEE2E2' },
            { title: '7p Birthday Party', start: '2025-04-12', backgroundColor: '#E6EFFF', textColor: '#3B82F6', borderColor: '#E6EFFF' }
          ]}
          height="auto"
          dayMaxEvents={3}
          fixedWeekCount={false}
          firstDay={1} // Start week on Monday
          dayCellClassNames="calendar-day"
          dayHeaderClassNames="day-header"
          eventClassNames="calendar-event"
          aspectRatio={1.5}
          datesSet={handleDatesSet} // Listen for date changes
        />
      </div>
    </div>
  )
}

export default Calendar